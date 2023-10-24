<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Fulton J. Sheen',
            'birthdate' => '1895-05-08', 
            'nationality' => 'American',
            'biography' => 'Fulton Sheen, whose full name is Fulton John Sheen, was a renowned American bishop, author, and television personality. He was born on May 8, 1895, in El Paso, Illinois, and passed away on December 9, 1979. Sheen is best known for his work in Catholic media and evangelism.',
            'open_library_key' => 'OL18945A',
        ]);

        Author::create([
            'name' => 'Thomas Aquinas',
            'birthdate' => date('Y-01-01', strtotime('1225')), 
            'nationality' => 'Italian',
            'biography' => 'An Italian priest of the Catholic Church in the Dominican Order, and an influential philosopher and theologian in the tradition of scholasticism.',
            'open_library_key' => 'OL38887A',
        ]);

        Author::create([
            'name' => 'C.S. Lewis',
            'birthdate' => '1898-11-29', 
            'nationality' => 'English',
            'biography' => 'Clive Staples Lewis was an Irish-born British novelist, academic, medievalist, literary critic, essayist, lay theologian and Christian apologist.',
            'open_library_key' => 'OL38887A',
        ]);

        Author::create([
            'name' => 'Gilbert Keith Chesterton',
            'birthdate' => '1874-05-29', 
            'nationality' => 'English',
            'biography' => 'Gilbert Keith Chesterton was an English writer, lay theologian, poet, philosopher, dramatist, journalist, orator, literary and art critic, biographer, and Christian apologist.',
            'open_library_key' => 'OL18524A',
        ]);

        Author::create([
            'name' => 'J.R.R. Tolkien',
            'birthdate' => '1892-01-03', 
            'nationality' => 'English',
            'biography' => 'John Ronald Reuel Tolkien (1892-1973) was a major scholar of the English language, specialising in Old and Middle English. Twice Professor of Anglo-Saxon (Old English) at the University of Oxford, he also wrote a number of stories, including most famously The Hobbit (1937) and The Lord of the Rings (1954-1955), which are set in a pre-historic era in an invented version of the world which he called by the Middle English name of Middle-earth. This was peopled by Men (and women), Elves, Dwarves, Trolls, Orcs (or Goblins) and of course Hobbits. He has regularly been condemned by the Eng. Lit. establishment, with honourable exceptions, but loved by literally millions of readers worldwide.',
            'open_library_key' => 'OL26320A',
        ]);

        Author::create([
            'name' => 'Francis de Sales',
            'birthdate' => date('Y-01-01', strtotime('1567')),
            'nationality' => 'French',
            'biography' => 'Saint Francis de Sales (1567-1622) was a prominent French bishop, theologian, and writer known for his contributions to Catholic spirituality. He is particularly celebrated for his gentle and practical approach to the spiritual life, emphasizing the universal call to holiness and the importance of living a life of virtue.',
            'open_library_key' => 'OL116100A',
        ]);

        Author::create([
            'name' => 'George Weigel',
            'birthdate' => '1951-04-17', 
            'nationality' => 'American',
            'biography' => 'George Weigel, Distinguished Senior Fellow of the Ethics and Public Policy Center, is a Catholic theologian and one of America’s leading public intellectuals. He holds EPPC’s William E. Simon Chair in Catholic Studies. From 1989 through June 1996, Mr. Weigel was president of the Ethics and Public Policy Center, where he led a wide-ranging, ecumenical and inter-religious program of research and publication on foreign and domestic policy issues.',
            'open_library_key' => 'OL24734A',
        ]);

        Author::create([
            'name' => 'Augustine of Hippo',
            'birthdate' => '354-11-13', 
            'nationality' => 'Thagaste',
            'biography' => 'Augustine was born in Thagaste (present-day Souk Ahras, Algeria), a provincial Roman city in North Africa, the son of a Catholic mother and pagan father. He was raised a Catholic, and at age of 11, he went to school at Madaurus, about 19 miles south of Thagaste. There he learned both Latin literature and pagan beliefs and practices. He returned home in 369 and stayed for about two yeras, reading Ciceros dialogue Hortensius. At age 17 he went to Carthage to continue his education in rhetoric. He decided to follow the Manichaean religion, lived a hedonistic lifestyle for a time, and took a lover who stayed with him for over thirteen years and gave birth to his son. In 373-374, Augustine taught grammar at Tagaste. In 375 he moved to Carthage to conduct a school of rhetoric. In 383 he moved to Rome to establish another school. However, he was disappointed with the Roman schools, and instead of paying their fees, his students fled. Through his friends he obtained a professorship teaching rhetoric at the imperial court at Milan in 384. The young provincial won the job and headed north to take up his position in late 384. While in Rome, he turned away from Manichaeanism in favour of the skepticism of the New Academy movement. He became engaged and left his lover, but never married the girl to whom he had been engaged. In 386, converted to Catholic Christianity, left his career in rhetoric, devoted himself to serving God. He returned to north Africa, sold his patrimony and gave the money to the poor, and converted his family house into a monastic foundation. In 391 he was ordained a priest in Hippo Regius (now Annaba, Algeria). He became a famous preacher, and in 396 he was made assistant bishop and then full bishop shortly after. He left his monastery, but continued to lead a monastic life in the episcopal residence, and he remained Bishop of Hippo until his death in 430. Augustine was one of the most prolific authors of his time in surviving works, which number more than a hundred. Of these, the most well known is his Confessiones, written in 397-398.',
            'open_library_key' => 'OL22060A',
        ]);
    }
}
