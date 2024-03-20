<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MemoTest;

class MemoTestMutationsTest extends TestCase
{
    /**
     * Test memo test basic create.
     */
    public function test_memo_test_create_mutation(): void
    {
        // Create a memo test
        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createMemoTest(
                    input: {
                        name: "Memo Test Test"
                        images: {
                            create: [
                                { image_url: "/images/memo-test-test1.png"}
                                { image_url: "/images/memo-test-test2.jpg"}
                            ]
                        }
                    }
                ) {
                    id
                    name
                    images {
                        id
                        image_url
                    }
                }
            }
        ');

        // Get the memo test
        $memoTest = MemoTest::with('images')->find($response->json('data.createMemoTest.id'));

        // Check that the memo test was created
        $this->assertNotNull($memoTest);

        // Check that the memo test has the same data
        $response->assertJson([
            'data' => [
                'createMemoTest' => [
                    'id' => $memoTest->id,
                    'name' => $memoTest->name,
                    'images' => [
                        [
                            'id' => $memoTest->images[0]->id,
                            'image_url' => $memoTest->images[0]->image_url
                        ],
                        [
                            'id' => $memoTest->images[1]->id,
                            'image_url' => $memoTest->images[1]->image_url
                        ]
                    ]
                ]
            ]
        ]);

    }

    /**
     * Test memo test unique name validation.
     */
    public function test_existing_memo_test(): void
    {

        MemoTest::factory()->hasImages(2)->create(["name" => "Memo Test Test"]);

        // Tries to create a memo test with a name that already exists
        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createMemoTest(
                    input: {
                        name: "Memo Test Test"
                        images: {
                            create: [
                                { image_url: "/images/memo-test-test.png"}
                            ]
                        }
                    }
                ) {id}
            }
        ');
        $response->assertGraphQLValidationError("input.name", "The input.name has already been taken.");
    }

    /**
     * Test memo test image extension validation.
     */
    public function test_memo_test_image_extension(): void
    {
        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createMemoTest(
                    input: {
                        name: "Memo Test Test"
                        images: {
                            create: [
                                { image_url: "/images/memo-test-test3"}
                                { image_url: "/images/memo-test-test3.gif"}
                                { image_url: "/images/memo-test-test3.tiff"}
                            ]
                        }
                    }
                ) {id}
            }
        ');

        $response->assertGraphQLValidationError(
            "input.images.create.0.image_url",
            "The input.images.create.0.image url field must end with one of the following: .jpg, .jpeg, .png."
        );
        $response->assertGraphQLValidationError(
            "input.images.create.1.image_url",
            "The input.images.create.1.image url field must end with one of the following: .jpg, .jpeg, .png."
        );
        $response->assertGraphQLValidationError(
            "input.images.create.2.image_url",
            "The input.images.create.2.image url field must end with one of the following: .jpg, .jpeg, .png."
        );
    }

    /**
     * Test memo test name length validation.
     * 
     */
    public function test_memo_test_name_length(): void
    {
        // Tries to create a memo test with a name shorter than 4 characters
        $this->graphQL(/** @lang GraphQL */ ' mutation {createMemoTest(input: {name: "Mem"}) {id}}')
            ->assertGraphQLValidationError("input.name", "The input.name field must be at least 4 characters.");

        // Tries to create a memo test with a name longer than 100 characters
        $this->graphQL(/** @lang GraphQL */
            ' mutation {createMemoTest(
            input: {name: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse auctor, odio at tempus mattis, ligula purus varius odio."}
            ) {id}}'
        )->assertGraphQLValidationError("input.name", "The input.name field must not be greater than 100 characters.");
    }

    /**
     * Test memo test update mutation with images.
     */
    public function test_memo_test_update_mutation_with_images(): void
    {
        // Tries to update a memo test
        $memoTest = MemoTest::factory()->hasImages(2)->create();

        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                updateMemoTest(
                  input: {
                      id: ' . $memoTest->id . '
                      name: "Memo Test Test 2"
                      images: {
                          create: [
                              { image_url: "/images/memo-test-test3.jpeg"}
                              { image_url: "/images/memo-test-test4.jpg"}
                          ]
                          update: [{ id: ' . $memoTest->images[0]->id . ', image_url: "/images/memo-test-test5.jpg"}]
                          delete: [' . $memoTest->images[1]->id . ']
                      }
                  }
                ) {
                  id
                  name
                  images {
                      id
                      image_url
                  }
                }
              }
        ')->json('data.updateMemoTest');

        // Check that the memo test name was updated
        $this->assertNotSame($memoTest->name, $response['name']);

        // Check that the memo test image_url was updated
        $this->assertNotSame($memoTest->images[0]->image_url, $response['images'][0]['image_url']);

        // Check that the memo test image was deleted
        $this->assertNotSame($memoTest->images[1]->id, $response['images'][1]['id']);
        $this->assertArrayNotHasKey(2, $memoTest->images);
        $this->assertNotSame(count($memoTest->images), count($response['images']));
    }
}
