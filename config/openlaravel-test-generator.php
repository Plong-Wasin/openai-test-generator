<?php

// config for Wasinpwg/OpenlaravelTestGenerator
return [
    'messages' => [
        [
            "role" => "system",
            "content" => "I want you to act like a Laravel unit test professor. I will write you the code and you will respond unit test code. I want you to only reply code block, and nothing else. do not write explanations. Do not type commands unless I instruct you to do so. If my code don't have enough input. You must guess and reply code block to me."
        ],
        [
            "role" => "user",
            "content" => 'This is route [{"method":"GET","as":"api.users.index","url":"users","controller":"App\Http\Controllers\UserController@index"},{"method":"POST","as":"api.users.store","url":"users","controller":"App\Http\Controllers\UserController@store"},{"method":"GET","as":"api.users.show","url":"users/{user}","controller":"App\Http\Controllers\UserController@show"},{"method":"PUT","as":"api.users.update","url":"users/{user}","controller":"App\Http\Controllers\UserController@update"},{"method":"DELETE","as":"api.users.destroy","url":"users/{user}","controller":"App\Http\Controllers\UserController@destroy"}]'
        ],
        [
            "role" => "assistant",
            "content" => 'understood'
        ],
        [
            "role" => "user",
            "content" => '<?php

            namespace App\Http\Controllers;

            use App\Models\User;
            use Illuminate\Http\Request;

            class UserController extends Controller
            {
                public function index()
                {
                    $users = User::all();
                    return response()->json($users);
                }

                public function store(Request $request)
                {
                    $this->validate($request, [
                        \'name\' => \'required\',
                        \'email\' => \'required|email|unique:users\',
                        \'password\' => \'required|min:6\',
                    ]);

                    $user = User::create($request->all());

                    return response()->json($user, 201);
                }

                public function show($id)
                {
                    $user = User::findOrFail($id);
                    return response()->json($user);
                }

                public function update(Request $request, $id)
                {
                    $this->validate($request, [
                        \'name\' => \'required\',
                        \'email\' => \'required|email|unique:users,email,\' . $id,
                        \'password\' => \'required|min:6\',
                    ]);

                    $user = User::findOrFail($id);
                    $user->update($request->all());

                    return response()->json($user);
                }

                public function destroy($id)
                {
                    $user = User::findOrFail($id);
                    $user->delete();

                    return response()->json(null, 204);
                }
            }',
        ],
        [
            "role" => "assistant",
            "content" => '```php
            <?php

            namespace Tests\Feature;

            use App\Models\User;
            use Illuminate\Foundation\Testing\RefreshDatabase;
            use Illuminate\Foundation\Testing\WithFaker;
            use Tests\TestCase;

            class UserControllerTest extends TestCase
            {
                use RefreshDatabase;

                public function testCanListUsers()
                {
                    $user = User::factory()->create();

                    $response = $this->get(\'/users\');

                    $response->assertStatus(200)
                        ->assertJson([$user->toArray()]);
                }

                public function testCanCreateUser()
                {
                    $data = [
                        \'name\' => \'John Doe\',
                        \'email\' => \'john@example.com\',
                        \'password\' => \'secret123\',
                    ];

                    $response = $this->post(\'/users\', $data);

                    $response->assertStatus(201)
                        ->assertJson($data);
                }

                public function testCanShowUser()
                {
                    $user = User::factory()->create();

                    $response = $this->get(\'/users/\' . $user->id);

                    $response->assertStatus(200)
                        ->assertJson($user->toArray());
                }

                public function testCanUpdateUser()
                {
                    $user = User::factory()->create();

                    $data = [
                        \'name\' => \'Updated Name\',
                        \'email\' => \'updated@example.com\',
                        \'password\' => \'newpassword\',
                    ];

                    $response = $this->put(\'/users/\' . $user->id, $data);

                    $response->assertStatus(200)
                        ->assertJson($data);
                }

                public function testCanDeleteUser()
                {
                    $user = User::factory()->create();

                    $response = $this->delete(\'/users/\' . $user->id);

                    $response->assertStatus(204);
                    $this->assertDatabaseMissing(\'users\', [\'id\' => $user->id]);
                }
            }
            ```',
        ],
    ]
];
