<?php

namespace Wasinpwg\OpenlaravelTestGenerator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use ReflectionClass;
use SebastianBergmann\CodeCoverage\Driver\WriteOperationFailedException;

class OpenlaravelTestGeneratorCommand extends Command
{
    public $signature = 'openlaravel:generate-test {--class=*}';

    public $description = 'Generates a test file';

    public function handle(): int
    {
        $classes = $this->option('class');
        foreach ($classes as $class) {
            try {
                $this->info("Generating test for $class");
                if (!class_exists($class)) {
                    $this->error("Class $class not found");

                    continue;
                }
                $test = $this->generateTest($class);
                $this->writeFile($test);
            } catch (Exception $e) {
                $this->error("Error generating test for $class");
                $this->error($e->getMessage());
            }
        }

        return self::SUCCESS;
    }

    public function writeFile(string $text)
    {
        $namespace = $this->getNamespaceFromFileContent($text);
        $className = $this->getClassNameFromFileContent($text);
        $testDirectory = base_path('tests');
        $fileDirectory = $testDirectory . '/' . Str::of($namespace)->after('Tests')->replace('\\', '/');
        if (!file_exists($fileDirectory)) {
            File::makeDirectory($fileDirectory, recursive: true);
        }
        $filePath = $fileDirectory . '/' . $className . '.php';
        if (!file_exists($filePath)) {
            File::put($filePath, $text);
            $this->comment("Created file $filePath");
        } else {
            $this->error("File $filePath already exists");
            $newFilePath = $fileDirectory . '/' . $className . uniqid() . '.php';
            File::put($newFilePath, $text);
            $this->comment("Created file $newFilePath instead of $filePath");
        }
    }

    public function generateTest($className)
    {
        $reflection = new ReflectionClass($className);
        $filePath = $reflection->getFileName();
        $result = OpenAI::chat()->create([
            'model' => config('openlaravel-test-generator.model'),
            'messages' => [
                ...config('openlaravel-test-generator.messages'),
                [
                    'role' => 'user',
                    'content' => 'This is my route.' . json_encode($this->getRouteByController($className)),
                ],
                [
                    'role' => 'assistant',
                    'content' => 'understood',
                ],
                [
                    'role' => 'user',
                    'content' => File::get($filePath),
                ],
            ],
        ]);
        $responseContent = $result['choices'][0]['message']['content'];
        if ($result['choices'][0]['finish_reason'] != 'stop') {
            throw new WriteOperationFailedException('Failed to generate test');
        }

        return Str::of($responseContent)->ltrim('```php')->rtrim('```')->trim();
    }

    public function getRouteByController(string $controller)
    {
        $routeList = [];
        /** @phpstan-ignore-next-line */
        foreach (Route::getRoutes() as $route) {
            if (Str::startsWith($route->getActionName(), $controller)) {
                $routeList[] = [
                    'method' => implode('|', $route->methods()),
                    'as' => $route->getName(),
                    'url' => $route->uri(),
                    'controller' => $route->getActionName(),
                ];
            }
        }

        return $routeList;
    }

    public function getNamespaceFromFileContent($fileContent)
    {
        // Define the regular expression pattern to match the namespace declaration
        $pattern = '/namespace\s+([^\s;]+)/';

        // Perform a regular expression match to find the namespace declaration
        preg_match($pattern, $fileContent, $matches);

        // Extract the captured namespace from the match
        $namespace = $matches[1] ?? null;

        return $namespace;
    }

    public function getClassNameFromFileContent($fileContent)
    {
        // Define the regular expression pattern to match the class declaration
        $pattern = '/class\s+([^\s{]+)/';

        // Perform a regular expression match to find the class declaration
        preg_match($pattern, $fileContent, $matches);

        // Extract the captured class name from the match
        $className = $matches[1] ?? null;

        return $className;
    }
}
