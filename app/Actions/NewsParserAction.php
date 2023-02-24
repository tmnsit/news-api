<?php

namespace App\Actions;

use App\Models\LogParse;
use App\Models\News;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsParserAction
{

    public function handle(): void
    {
        $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';

        $timeStart = intval(round(microtime(true)*1000));
        $response = Http::get($url);
        $result = simplexml_load_string($response->body());
        $timeEnd = intval(round(microtime(true)*1000));

        $requestMilliseconds = $timeEnd - $timeStart;

        LogParse::query()->create([
            'method' => 'get',
            'url' => $url,
            'response' => $response->body(),
            'time_request' => $requestMilliseconds
        ]);



        if (isset($result->channel->item)) {
            foreach ($result->channel->item as $item) {
                $news = (array)$item;
                $news['rbc_news'] = (array)$item->children('rbc_news', true);
                if (!News::query()->where('ext_id', (string)$news['rbc_news']['news_id'])->exists())
                {
                    $newsProps = [
                        'title' => $news['title'],
                        'description' => $news['description'],
                        'date_publish' => date('Y-m-d H:i:s', (int)$news['rbc_news']['newsDate_timestamp']),
                        'author' => array_key_exists('author', $news) ? (string) $news['author'] : null,
                        'ext_id' => (string) $news['rbc_news']['news_id'],
                        'images' => []
                    ];
                    if(key_exists('image', $news['rbc_news']))
                    {
                        if (is_array($news['rbc_news']['image'])) {
                            foreach ($news['rbc_news']['image'] as $image)
                            {
                                preg_match('/.([a-z||A-Z]*)$/', $image->url, $matches);
                                $uuid = Str::uuid()->toString();
                                Storage::disk('public')->put('news/' . $uuid . $matches[0], file_get_contents($image->url));
                                $newsProps['images'][] = '/storage/news/' . $uuid . $matches[0];
                            }
                        } else {
                            preg_match('/.([a-z||A-Z]*)$/', $news['rbc_news']['image']->url, $matches);
                            $uuid = Str::uuid()->toString();
                            Storage::disk('public')->put('news/' . $uuid . $matches[0], file_get_contents($news['rbc_news']['image']->url));
                            $newsProps['images'][] = '/storage/news/' . $uuid . $matches[0];
                        }
                    }

                    News::query()->create($newsProps);
                }
            }
        }
    }


}
