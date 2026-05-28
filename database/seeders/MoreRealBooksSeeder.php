<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class MoreRealBooksSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sains' => Category::firstOrCreate(['slug' => 'sains'], ['name' => 'Sains']),
            'Sastra' => Category::firstOrCreate(['slug' => 'sastra'], ['name' => 'Sastra']),
            'Sejarah' => Category::firstOrCreate(['slug' => 'sejarah'], ['name' => 'Sejarah']),
            'Teknologi' => Category::firstOrCreate(['slug' => 'teknologi'], ['name' => 'Teknologi']),
            'Agama' => Category::firstOrCreate(['slug' => 'agama'], ['name' => 'Agama']),
        ];

        $books = [
            [
                'title' => 'The Origin of Species',
                'author' => 'Charles Darwin',
                'isbn' => '9780140432053',
                'publisher' => 'Penguin Classics',
                'year' => '1859',
                'category' => 'Sains',
                'description' => 'A work of scientific literature that is considered to be the foundation of evolutionary biology.',
                'cover' => 'https://books.google.com/books/content?id=Y990DQAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Cosmos',
                'author' => 'Carl Sagan',
                'isbn' => '9780345331359',
                'publisher' => 'Ballantine Books',
                'year' => '1980',
                'category' => 'Sains',
                'description' => 'The story of fifteen billion years of cosmic evolution transforming matter and life into consciousness.',
                'cover' => 'https://books.google.com/books/content?id=8v0fAQAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Art of Computer Programming',
                'author' => 'Donald Ervin Knuth',
                'isbn' => '9780201896831',
                'publisher' => 'Addison-Wesley',
                'year' => '1968',
                'category' => 'Teknologi',
                'description' => 'A comprehensive monograph which covers many kinds of programming algorithms and their analysis.',
                'cover' => 'https://books.google.com/books/content?id=hjEFCAAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Refactoring: Improving the Design of Existing Code',
                'author' => 'Martin Fowler',
                'isbn' => '9780201485677',
                'publisher' => 'Addison-Wesley Professional',
                'year' => '1999',
                'category' => 'Teknologi',
                'description' => 'Refactoring is a controlled technique for improving the design of an existing code base.',
                'cover' => 'https://books.google.com/books/content?id=5w9R3Z29vg8C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Code Complete',
                'author' => 'Steve McConnell',
                'isbn' => '9780735619678',
                'publisher' => 'Microsoft Press',
                'year' => '2004',
                'category' => 'Teknologi',
                'description' => 'Widely considered one of the best practical guides to programming.',
                'cover' => 'https://books.google.com/books/content?id=6z_Y6Lx_H98C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '9780451524935',
                'publisher' => 'Signet Classic',
                'year' => '1949',
                'category' => 'Sastra',
                'description' => 'A dystopian social science fiction novel and cautionary tale.',
                'cover' => 'https://books.google.com/books/content?id=iXn5U2uS49sC&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'Brave New World',
                'author' => 'Aldous Huxley',
                'isbn' => '9780060850524',
                'publisher' => 'Harper Perennial Modern Classics',
                'year' => '1932',
                'category' => 'Sastra',
                'description' => 'A dystopian novel set in a futuristic World State.',
                'cover' => 'https://books.google.com/books/content?id=OQp_AgAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'isbn' => '9780618640157',
                'publisher' => 'Houghton Mifflin Harcourt',
                'year' => '1954',
                'category' => 'Sastra',
                'description' => 'An epic high-fantasy novel written by English author and scholar J. R. R. Tolkien.',
                'cover' => 'https://books.google.com/books/content?id=1S9_AgAAQBAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'A People\'s History of the United States',
                'author' => 'Howard Zinn',
                'isbn' => '9780060838652',
                'publisher' => 'Harper Perennial Modern Classics',
                'year' => '1980',
                'category' => 'Sejarah',
                'description' => 'The book was a runner-up for the National Book Award.',
                'cover' => 'https://books.google.com/books/content?id=k_T67S9Y_Y8C&printsec=frontcover&img=1&zoom=1&source=gbs_api'
            ],
            [
                'title' => 'The Prophet',
                'author' => 'Kahlil Gibran',
                'isbn' => '9780394404288',
                'publisher' => 'Alfred A. Knopf',
                'year' => '1923',
                'category' => 'Sastra',
                'description' => 'A book of 26 prose poetry fables written in English by the Lebanese-American poet and writer Kahlil Gibran.',
                'cover' => 'https://books.google.com/books/content?id=A_S8AAAAMAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api'
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
