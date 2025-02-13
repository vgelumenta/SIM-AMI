<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class UserControllerTest extends TestCase
{
    /**
     * Test the getUser method with a successful response.
     */
    public function testGetUserSuccessfulResponse()
    {
        // Mock URL dan Token API
        $apiUrl = env('API_SEARCH_USER_URL');
        $apiToken = env('API_USER_TOKEN');

        // Mock data response API
        $mockResponse = [
            'data' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
                ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com'],
            ]
        ];

        // Palsukan respons dari Http::withToken
        Http::fake([
            $apiUrl => Http::response($mockResponse, 200),
        ]);

        // Kirim permintaan ke endpoint getUser
        $response = $this->getJson('/api/getUser?keyword=John');

        // Periksa apakah respons berhasil
        $response->assertStatus(200);
        $response->assertJson($mockResponse);

        // Pastikan API dipanggil dengan token dan parameter yang benar
        Http::assertSent(function ($request) use ($apiUrl, $apiToken) {
            return $request->url() === $apiUrl
                && $request->hasHeader('Authorization', "Bearer $apiToken")
                && $request->data() === ['keyword' => 'John'];
        });
    }

    /**
     * Test the getUser method with a failed response.
     */
    // public function testGetUserFailedResponse()
    // {
    //     // Mock URL dan Token API
    //     $apiUrl = env('API_SEARCH_USER_URL');

    //     // Palsukan respons gagal dari Http::withToken
    //     Http::fake([
    //         $apiUrl => Http::response(null, 500),
    //     ]);

    //     // Kirim permintaan ke endpoint getUser
    //     $response = $this->getJson('/api/getUser?keyword=Unknown');

    //     // Periksa apakah respons memiliki status 500
    //     $response->assertStatus(500);
    //     $response->assertJson(['message' => 'Failed to fetch data']);
    // }
}

