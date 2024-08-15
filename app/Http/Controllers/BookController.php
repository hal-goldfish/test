<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

use GuzzleHttp\Client;
use Inertia\Inertia;
use App\Models\Book;





class BookController extends Controller {

    private function get_and_save_data_from_outside(Book &$book) {
        $isbn = $book->ISBN;
        $url = "https://ndlsearch.ndl.go.jp/api/sru?operation=searchRetrieve&query=isbn%3d\"".$isbn."\"";
        $client = new Client();
        $raw_data = $client->request("GET", $url)->getBody()->getContents();

        // タイトル
        $title = "";
        $idx = strpos($raw_data, "title");
        for ($i = $idx+9; $raw_data[$i] != '&'; $i++) {
            $title.=$raw_data[$i];
        }
        $book->title = $title;

        // 著者
        $author = "";
        $idx = strpos($raw_data, "creator");
        for ($i = $idx+11; $raw_data[$i] != '&'; $i++) {
            $author .= $raw_data[$i];
        }
        $book->author = $author;

        // 出版社
        $publisher = "";
        $idx = strpos($raw_data, "publisher");
        for ($i = $idx+13; $raw_data[$i] != '&'; $i++) {
            $publisher .= $raw_data[$i];
        }
        $book->publisher = $publisher;

        $book->save();
    }

    private function get_title($isbn) {
        $url = "https://ndlsearch.ndl.go.jp/api/sru?operation=searchRetrieve&query=isbn%3d\"".$isbn."\"";
        $client = new Client();
        $raw_data = $client->request("GET", $url)->getBody()->getContents();
        $idx = strpos($raw_data, "title");
        // echo($idx);
        $title = "";
        for ($i = $idx+9; $raw_data[$i] != '&'; $i++) {
            $title.=$raw_data[$i];
        }
        return $title;
    }


    public function index($isbn) {
        return Inertia::render('Book/Show', [
            'title' => $this->get_title($isbn),
        ]);
    }


    public function save(Request $request) {

        $isbn = $request->isbn;

        // return redirect()->route('dashboard');
        // $request->session()->flash('message', 'saved!');

        $book = Book::create(['ISBN' => $isbn]);
        $this->get_and_save_data_from_outside($book);

        return back();
    }

    public function test_python() {
        $command = "python3 ". app_path()."/Python/test.py";
        exec($command, $output);

        if (empty($output)) {
            return Inertia::render('Test_python', [
                'output' => 'aaa',
            ]);
        }
        else {
            return Inertia::render('Test_python', [
                'output' => $output[0],
            ]);
        }
    }


}
