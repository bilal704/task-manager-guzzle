<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Task extends Model
{
    protected $fillable = ['title', 'status', 'due_date', 'user_id'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'due_date' => $this->due_date,
        ];
    }

    public static function indexTasks()
    {
        \Log::info('Starting indexTasks');
        $client = new GuzzleClient();
        \Log::info('Guzzle client created');
        try {
            $tasks = self::all();
            \Log::info('Tasks fetched: ' . $tasks->count());
        } catch (\Exception $e) {
            \Log::error('Failed to fetch tasks: ' . $e->getMessage());
            throw $e;
        }

        $host = env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200');

        foreach ($tasks as $task) {
            try {
                $client->put("{$host}/tasks/_doc/{$task->id}", [
                    'json' => $task->toSearchableArray(),
                ]);
            } catch (RequestException $e) {
                \Log::error("Failed to index task ID {$task->id}: " . $e->getMessage());
            }
        }
    }

    public static function search($query)
    {
        \Log::info('Starting search for query: ' . $query);
        $client = new GuzzleClient();
        $host = env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200');

        try {
            $response = $client->get("{$host}/tasks/_search", [
                'json' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['title', 'status'],
                        ],
                    ],
                ],
            ]);
            
            $body = json_decode($response->getBody(), true);
            $ids = array_column($body['hits']['hits'], '_id');
            $results = self::whereIn('id', $ids)->get();
            \Log::info('Search successful, found ' . $results->count() . ' results');
            return $results;
        } catch (RequestException $e) {
            \Log::error("Search failed: " . $e->getMessage());
            return collect();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}