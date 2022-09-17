<?php

/*
Suppose we're building a digital library, where people can come and read books
- so we can consider a book as an object
- title, author, no. of pages, etc are the properties of that object
- reading, searching for a keyword, adding new books to the library,
deleting a book, etc are the actions/functions/methods associated with it
*/

class Book {
    public int $id;
    public string $title;
    public string $author;
    public float $price;
    public int $totalPages;
    public string $genre;

    public $content;

    public function __construct(int $id) {
        $this->id = $id;
        switch ($id) {
            case 10:
                $this->title = "Sherlock Holmes";
                $this->genre = "Thriller";
                $this->author = "Arthur Conan Doyle";
                break;
            case 25:
                $this->title = "The Alchemist";
                $this->genre = "Novel";
                $this->author = "Paulo Coelho";
                break;
            default:
                $this->title = "";
                $this->genre = "";
        }
    }

    public function readBook() : string {
        
        $this->content = "You're reading $this->title by $this->author in $this->genre";
        return $this->content;
    }

    public function search(string $word) {
        return "10 results found for the word '$word'";
    }

    public static function createNewBook($title, $author) : bool {
        //...code to save the book details into the database
        echo "Book $title saved successfully";
        return true;
    }

    public static function deleteBook(int $id) : bool {
        //...code to delete book from the db
        return true;
    }
}

$myBook = new Book(10);
echo $myBook->readBook(), "<br>";
echo $myBook->search("evidence");

Book::createNewBook("Balidweep", "Balidweep");