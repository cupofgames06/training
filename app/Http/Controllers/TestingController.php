<?php

namespace App\Http\Controllers;

use OpenAI;

class TestingController extends Controller
{
    public function test()
    {

        /*$file_path = 'test.txt';
        $file_path = urlencode($file_path);
        $url = 'http://pyia.test:8000/api/summarize?file_path=' . $file_path;
        $response = Http::get($url);
        dd($response->json());

        try {
            $response = Http::get('http://pyia.test:8000/api/extract-questions', [
                'file_path' => $file_path,
            ]);

            // check if the request was successful
            if ($response->successful()) {
                $embeddings = $response->json();
                dump([$embeddings[10],$embeddings[32]]);

                $questions = urlencode(json_encode([$embeddings[10], $embeddings[32]]));
                $file_path = urlencode($file_path);
                $url = 'http://pyia.test:8000/api/answers?questions=' . $questions . '&file_path=' . $file_path;

                $response = Http::post($url);

                dd($response->json());

            } else {
                // Handle error response
                return 'Error: ' . $response->body();
            }

        } catch (\Exception $e) {
            // Handle exception
            return 'Exception: ' . $e->getMessage();
        }

        die();
*/

        $yourApiKey = config('openai.api_key');
        $client = OpenAI::client($yourApiKey);

        $base_knowledge = "The story takes place from January 31 1951 to february 1st 1951, on Maupiti, a fictive small island in the Indian Ocean, 350 km north east of Mauritius Island, famous  amongst the sailors for its sheltered bay and small port as well as for its brothel, Maguy\'s hotel.
The user is Jerome Lange, 35 years old parisian private detective on vacations after solving a famous case.
thanks to one of his rich and grateful client, lord Byron, he  sails aboard the 'Brisban', a luxury sail yachts with two crew members, Bob, the captain and Anton the second.
They first go to Madagascar through suez canal. Jerome receives there a letter from his old friend Max, inviting to visit him in Japan.
Jerome accepts, and ask the crew to sail to Japan.
A hurricane name 'Harry' stopped their trip and forced them on January 30th at 11pm, to stop on Maupiti.
During the night, another boat, the Bamboo, a fishing trawler with a broken hull due to the hurricane, arrived on Maupiti.
Marie, Anita and Sue, are prostitutes living and working at Maguy's hotel, a former colonial mansions turned into a classy old brothel, situated south of Maupiti, next to the port.
Maguy come to see you in your cabin at 9.30 am on january 31th, to tell you that one of her employee, Marie, has disappeared. Her window has been broken.
Maguy suspects a kidnapping, and asks for Jerome Lange help. He now has less than 36 hours to solve the case.";

        $actor_description = "You are Anita, spanish rebel born on december 6th 1923 in a small andalousian village who exiled on Maupiti to escape Franco's dictature after 3 members of her resistance group were betrayed and arrested.
You are smart,sarcastic,tough,funny,brave. height 157cm, cute. You are currently sitting on the beach. It is 17:00. Your confidence in the user is limited for now.";

        $user_knowledge = "the user knows that you weren't a friend of Marie, that Bob does not like you and suspect you of being associated with marie disappearance. Jerome also discovered that Marie was not kidnapped, and is indeed part of a drug and weapons traffic.";
        $actor_knowledge = "You do not know that Marie was not kidnapped, and is indeed part of a drug and weapons traffic.";
        $already_talked = "the user has already talk to you";
        $precisions = "do not answer with a question. Your answer will not exceed 25 words.";

        $knowledge = $base_knowledge . ' ' . $actor_description . ' ' . $user_knowledge . ' ' . $actor_knowledge . ' ' . $already_talked . ' ' . $precisions;
        $knowledge = trim(str_replace("\n", "", $knowledge));
        $messages = [
            ["role" => "system", "content" => strtolower($knowledge)],
            ["role" => "user", "content" => "What do you think of anton ? ", "name" => "jerome"],
            ["role" => "assistant", "content" => "I needed to escape Franco's dictatorship. Maguy gave me a job and a place to stay. Plus, I'm good at it."],
            ["role" => "user", "content" => "good at what ?", "name" => "jerome"]
        ];

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'temperature' => 0.7,
            "messages" => [
                ["role" => "system", "content" => strtolower($knowledge)],
                ["role" => "user", "content" => "What do you think of anton ? ", "name" => "jerome"],
                ["role" => "assistant", "content" => "I needed to escape Franco's dictatorship. Maguy gave me a job and a place to stay. Plus, I'm good at it."],
                ["role" => "user", "content" => "good at what ?", "name" => "jerome"]
            ]
        ]);

        dd($result);

        /*
         * $v = estimateArrayTokens($knowledge);

        echo $v.'<br>';
        $api = new TextRankFacade();
        $summary = $api->summarizeTextBasic($knowledge);

        $stopWords = new English();
        $api->setStopWords($stopWords);
        if ($v === false) {
            $summary = $api->summarizeTextBasic($knowledge);
            echo $v = estimateTokenValue([$summary, $messages]);
        }
        *
         * /
        //$q = new Qa();

        $input['anita'] = [
            'what do you think of Marie' => [
                'text' => '...',
                'min_confidence' => 5
            ],

        ];

        $questions = array_keys($input);

        $vectors = $openia->embeddings($questions)['data'];

        // Initialize Pinecone
        $pinecone = new Pinecone(config('pinecone.api_key'), config('pinecone.environment'));
        foreach ($vectors as $v) {

            $response = $pinecone->index('maupiti-knowledgebase')->vectors()->upsert(vectors: [
                'id' => 'vector_' . $v['index'],
                'values' => $v['embedding'],
                'metadata' => [
                    'meta1' => 'value1',
                ]
            ]);
        }

        if ($response->successful()) {
            dd($response->json());
        }

        /*
         * $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'b', 'b', 'b'];

        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        $predicted = $classifier->predict([3, 2]);
        dd($predicted);
        */
    }

    public function uploadDocument()
    {

    }
}
