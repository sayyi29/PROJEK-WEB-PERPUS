<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class HardcodedBooksSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Teknologi' => Category::firstOrCreate(['slug' => 'teknologi'], ['name' => 'Teknologi', 'rack' => 'A1']),
            'Sains' => Category::firstOrCreate(['slug' => 'sains'], ['name' => 'Sains', 'rack' => 'B1']),
            'Sastra' => Category::firstOrCreate(['slug' => 'sastra'], ['name' => 'Sastra', 'rack' => 'C1']),
            'Sejarah' => Category::firstOrCreate(['slug' => 'sejarah'], ['name' => 'Sejarah', 'rack' => 'D1']),
            'Agama' => Category::firstOrCreate(['slug' => 'agama'], ['name' => 'Agama', 'rack' => 'E1']),
        ];

        $books = [
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'publisher' => 'Prentice Hall',
                'year' => '2008',
                'category' => 'Teknologi',
                'description' => 'Even bad code can function. But if code isn\'t clean, it can bring a development organization to its knees.',
                'cover' => 'https://books.google.com/books/content?id=hjEFCAAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt, David Thomas',
                'isbn' => '9780201616224',
                'publisher' => 'Addison-Wesley Professional',
                'year' => '1999',
                'category' => 'Teknologi',
                'description' => 'The Pragmatic Programmer is one of those rare tech books you\'ll read, re-read, and read again over the years.',
                'cover' => 'https://books.google.com/books/content?id=5w9R3Z29vg8C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'author' => 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides',
                'isbn' => '9780201633610',
                'publisher' => 'Addison-Wesley',
                'year' => '1994',
                'category' => 'Teknologi',
                'description' => 'Capturing a body of knowledge that has never been documented before.',
                'cover' => 'https://books.google.com/books/content?id=6z_Y6Lx_H98C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '9780553380163',
                'publisher' => 'Bantam Books',
                'year' => '1988',
                'category' => 'Sains',
                'description' => 'A landmark volume in science writing by one of the great minds of our time.',
                'cover' => 'https://books.google.com/books/content?id=v-0fAQAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Selfish Gene',
                'author' => 'Richard Dawkins',
                'isbn' => '9780198788607',
                'publisher' => 'Oxford University Press',
                'year' => '1976',
                'category' => 'Sains',
                'description' => 'Inherently selfish genes, as interpreted by Richard Dawkins.',
                'cover' => 'https://books.google.com/books/content?id=W990DQAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'publisher' => 'Harper',
                'year' => '2011',
                'category' => 'Sejarah',
                'description' => 'From a renowned historian comes a groundbreaking narrative of humanity\'s creation and evolution.',
                'cover' => 'https://books.google.com/books/content?id=1S9_AgAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '9780743273565',
                'publisher' => 'Scribner',
                'year' => '1925',
                'category' => 'Sastra',
                'description' => 'The novel that helped define the Jazz Age.',
                'cover' => 'https://books.google.com/books/content?id=iXn5U2uS49sC&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '9780061120084',
                'publisher' => 'Harper Perennial Modern Classics',
                'year' => '1960',
                'category' => 'Sastra',
                'description' => 'The memorable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it.',
                'cover' => 'https://books.google.com/books/content?id=OQp_AgAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Islam: A Short History',
                'author' => 'Karen Armstrong',
                'isbn' => '9780812966183',
                'publisher' => 'Modern Library',
                'year' => '2000',
                'category' => 'Agama',
                'description' => 'A clear and concise guide to the history and meaning of Islam.',
                'cover' => 'https://books.google.com/books/content?id=A_S8AAAAMAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Guns, Germs, and Steel',
                'author' => 'Jared Diamond',
                'isbn' => '9780393038910',
                'publisher' => 'W.W. Norton & Company',
                'year' => '1997',
                'category' => 'Sejarah',
                'description' => 'The fates of human societies.',
                'cover' => 'https://books.google.com/books/content?id=k_T67S9Y_Y8C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
        ];

        foreach ($books as $bookData) {
            Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'isbn' => $bookData['isbn'],
                'publisher' => $bookData['publisher'],
                'year' => $bookData['year'],
                'category_id' => $categories[$bookData['category']]->id,
                'description' => $bookData['description'],
                'stock' => rand(1, 10),
                'cover_image' => $bookData['cover'],
                'genre' => $bookData['category'],
                'synopsis' => $bookData['description']
            ]);
        }
    }
}
