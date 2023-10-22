<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'The Screwtape Letters',
            'publication_year' => 1961, 
            'description' => 'A milestone in the history of popular theology, The Screwtape Letters is an iconic classic on spiritual warfare and the dynamics of temptation.This profound and striking narrative takes the form of a series of letters from Screwtape, a devil high in the Infernal Civil Service, to his nephew Wormwood, a junior colleague engaged in his first mission on earth, trying to secure the damnation of a young man who has just become a Christian. Although the young man initially looks to be a willing victim, he changes his ways and is "lost" to the young devil.Dedicated to Lewis friend and colleague J. R. R. Tolkien, The Screwtape Letters is a timeless classic on spiritual conflict and the psychology of temptation which are part of our religious experience',
            'open_library_key' => 'OL71072W', 
            'editions_key' => '', 
            'author_id' => 3, 
        ]);

        Book::create([
            'title' => 'The problem of pain',
            'publication_year' => 1948, 
            'description' => 'Why must humanity suffer? In this elegant and thoughtful work, C. S. Lewis questions the pain and suffering that occur everyday and how this contrasts with the notion of a God that is both omnipotent and good. An answer to this critical theological problem is found within these pages.',
            'open_library_key' => 'OL71167W', 
            'editions_key' => '', 
            'author_id' => 3, 
        ]);

        Book::create([
            'title' => 'Your Life Is Worth Living',
            'publication_year' => 2001, 
            'description' => 'Archbishop Fulton J. Sheen was one of the leading religious figures of the 20th century and the chief spokesman of American Catholicism. Previously unpublished, this work reflects his 16 years of service as national director of the Society for the Propagation of the Faith and 26 years on radio and television. It is the only work where he describes his Christian philosophy. Sheen created this compendium in 1965 in the privacy of his New York City residence at the conclusion of the Second Vatican Council. The series ran over 21 hours on 25 vinyl records. It is his response to millions of letters he received from people around the world writing him in search of truth, salvation, and spiritual guidance and was also conceived to explain his mission to evangelize the world. This book provides Sheen’s answers to life’s most profound questions and presents the Christian philosophy of life. Released solely on audiocassette for 20 years, it is now available for the first time in print.',
            'open_library_key' => 'OL445165W', 
            'editions_key' => '', 
            'author_id' => 1, 
        ]);

        Book::create([
            'title' => 'Three to get married',
            'publication_year' => 1951, 
            'description' => 'One of the greatest and best-loved spokesmen for the Catholic Faith here sets out the Churchs beautiful understanding of marriage in his trademark clear and entertaining style. Frankly and charitably, Sheen presents the causes of and solutions to common marital crises, and tells touching real-life stories of people whose lives were transformed through marriage. He emphasizes that our Blessed Lord is at the center of every successful and loving marriage. This is a perfect gift for engaged couples, or for married people as a fruitful occasion for self-examination.',
            'open_library_key' => 'OL111054W', 
            'editions_key' => '', 
            'author_id' => 1, 
        ]);

        Book::create([
            'title' => 'Leaf by Niggle',
            'publication_year' => 1945, 
            'description' => 'In this story, an artist named Niggle lives in a society that does not value art. Working only to please himself, he paints a canvas of a great tree with a forest in the distance. He invests each and every leaf of his tree with obsessive attention to detail, making every leaf uniquely beautiful. Niggle ends up discarding all his other artworks, or tacks them onto the main canvas, which becomes a single vast embodiment of his vision.',
            'open_library_key' => '', 
            'editions_key' => '', 
            'author_id' => 5, 
        ]);

        Book::create([
            'title' => 'Introduction à la vie dévote',
            'publication_year' => 1662, 
            'description' => 'Francis de Sales’s Introduction to the Devout Lifehas remained a uniquely accessible and relevant treasure of devotion for nearly four hundred years. As Bishop of Geneva in the first quarter of the seventeenth century, Francis de Sales saw to the spiritual needs of everyone from the poorest peasants to court ladies. The desire to be closer to God that he found in people from all levels of society led him to compile these instructions on how to live in Christ. Francis’s compassionateIntroduction leads the reader through practical ways of attaining a devout life without renouncing the world and offers prayers and meditations to strengthen devotion in the face of temptation and hardship.',
            'open_library_key' => 'OL1140014W', 
            'editions_key' => '', 
            'author_id' => 6, 
        ]);

        Book::create([
            'title' => 'De civitate Dei',
            'publication_year' => 426, 
            'description' => '"The City of God," also known as "De Civitate Dei" in Latin, is a monumental work of Christian philosophy and theology written by Saint Augustine of Hippo in the early 5th century. This influential text is one of the most important works in Western Christian thought and has had a profound impact on the development of Christian theology and Western philosophy.',
            'open_library_key' => 'OL8793006W', 
            'editions_key' => '', 
            'author_id' => 8, 
        ]);
        
        Book::create([
            'title' => 'Summa theologica',
            'publication_year' => 1467, 
            'description' => 'Thomas magnum opus, comprising a systematic integration of Aristotelian philosophy with Christianity. Covers topics such as the nature and existence of God, human nature, law and morality and the relationship of God, world and humans.',
            'open_library_key' => 'OL15314568W', 
            'editions_key' => '', 
            'author_id' => 2, 
        ]);
    }
}
