<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private function getBlogInfo(){
        $globals = $this->api('globals');

        $info = [];
        foreach ($globals as $g) {
            $info[$g['label']] = $g['value'];
        }
        return $info;
    }

    public function index(Request $request){
        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $each = 3;
        $offset = 0;
        if($request->has('page')) $offset = $each * ($request->get('page') - 1);
        $total = $this->api('posts', 'count');
        $total_posts = ceil($total / $each);

        $posts =  $this->api('posts', 'sort=created_at:DESC,id:DESC&limit='.$each.'&offset='.$offset.'&timestamps');
        
        return view('app', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'posts' => $posts, 'total_posts' => $total_posts]);
    }

    public function getPageByURL($url){
        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $page = $this->api('pages', 'first&where[url]='.$url);

        return view('page', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'page' => $page]);
    }

    public function getPostByURL($url, $errors = [], $success = false){
        session_start();

        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $post = $this->api('posts', "where[url]=".$url."&first&timestamps");
        $comments = $this->api('comments', "where[post]=".$post['id'].'&timestamps');

        return view('post', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'post' => $post, 'comments' => $comments, 'errors' => $errors, 'success' => $success]);
    }

    public function getPostsByCategory($url, Request $request){
        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $each = 3;
        $offset = 0;
        if($request->has('page')) $offset = $each * ($request->get('page') - 1);

        $posts = $this->api('posts', 'whereRelation[category][url]='.$url.'&sort=created_at:DESC,id:DESC&limit='.$each.'&offset='.$offset.'&timestamps');

        $total = $this->api('posts', 'whereRelation[category][url]='.$url.'&count');
        $total_posts = ceil($total / $each);

        return view('app', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'posts' => $posts, 'total_posts' => $total_posts, 'url' => $url]);
    }

    public function getPostsByAuthor($id, Request $request){
        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $each = 3;
        $offset = 0;
        if($request->has('page')) $offset = $each * ($request->get('page') - 1);

        $posts = $this->api('posts', 'where[author]='.$id.'&sort=created_at:DESC,id:DESC&limit='.$each.'&offset='.$offset.'&timestamps');

        $total = $this->api('posts', 'where[author]='.$id.'&count');
        $total_posts = ceil($total / $each);

        return view('app', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'posts' => $posts, 'total_posts' => $total_posts]);
    }

    public function getPostsByTags($tag, Request $request){
        $blog_info = $this->getBlogInfo();
        $pages = $this->api('pages');
        $categories = $this->api('categories');
        $tags = $this->api('tags');

        $each = 3;
        $offset = 0;
        if($request->has('page')) $offset = $each * ($request->get('page') - 1);
        
        $posts = $this->api('posts', 'whereRelation[tags][tag]='.$tag.'&sort=created_at:DESC,id:DESC&limit='.$each.'&offset='.$offset.'&timestamps');

        $total = $this->api('posts', 'whereRelation[tags][tag]='.$tag.'&count');
        $total_posts = ceil($total / $each);

        return view('app', ['blog_info' => $blog_info, 'pages' => $pages, 'categories' => $categories, 'tags' => $tags, 'posts' => $posts, 'total_posts' => $total_posts]);
    }

    public function postComment($id, Request $request){
        $post = $this->api('posts', 'first&where[id]='.$id);

        if($post !== ''){
            $comment['name'] = $request->get('name');
            $comment['e-mail'] = $request->get('email');
            $comment['comment'] = $request->get('comment');
            $comment['draft'] = 1;
            $comment['post'] = $post['id'];

            $url = env('ELMAPI_API_URL').'/comments';
            $send = Http::withOptions(['verify' => false])
                        ->accept('application/json')
                        ->withToken(env('ELMAPI_API_TOKEN'))
                        ->post($url, $comment);

            $response = $send->json();

            session_start();
            if(isset($response['errors'])){
                $_SESSION['errors'] = $response['errors'];

                return redirect('/'.$post['url']);
            } else {
                unset($_SESSION['errors']);
                $_SESSION['success'] = 'success';
                return redirect('/'.$post['url']);
            }
        }
    }

    private function api($collection='', $params=[]){
        $url = env('ELMAPI_API_URL').'/'.$collection;

        $response = Http::withOptions(['verify' => false])
                        ->accept('application/json')
                        ->withToken(env('ELMAPI_API_TOKEN'))
                        ->get($url, $params);
        
        return $response->json();
    }
}
