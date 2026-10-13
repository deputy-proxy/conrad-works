<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Book;
use App\Models\BookableSlot;
use App\Models\Booking;
use App\Models\Course;
use App\Models\DaughterMessage;
use App\Models\Habit;
use App\Models\HabitCompletion;
use App\Models\MyRole;
use App\Models\MyRoleRepresentative;
use App\Models\Song;
use App\Models\User;
use App\Models\Venture;
use App\Models\WifeMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RoleDomainsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->first();

        if (! $user) {
            $ownerName = env('OWNER_NAME');
            $ownerEmail = env('OWNER_EMAIL');
            $ownerPassword = env('OWNER_PASSWORD');

            if (blank($ownerName) || blank($ownerEmail) || blank($ownerPassword)) {
                throw new \RuntimeException(
                    'No owner account exists. Set OWNER_NAME, OWNER_EMAIL, and OWNER_PASSWORD before seeding.'
                );
            }

            $user = User::create([
                'name' => $ownerName,
                'email' => $ownerEmail,
                'password' => $ownerPassword,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            [
                'key' => 'human',
                'name' => 'Human',
                'article' => 'a',
                'short_description' => 'The person behind all the roles.',
                'description' => 'Habits, routines and small daily actions that make life better.',
                'type' => 'simple',
                'icon' => 'heroicon-o-user',
                'color' => '#111111',
                'sort_order' => 1,
                'is_featured' => false,
            ],
            [
                'key' => 'husband',
                'name' => 'Husband',
                'article' => 'a',
                'short_description' => 'Messages, memories and thoughts for my wife.',
                'description' => 'A private collection of messages and moments dedicated to my wife.',
                'type' => 'simple',
                'icon' => 'heroicon-o-heart',
                'color' => '#111111',
                'sort_order' => 2,
                'is_featured' => false,
            ],
            [
                'key' => 'father',
                'name' => 'Father',
                'article' => 'a',
                'short_description' => 'Letters and memories for my daughter.',
                'description' => 'Things I want my daughter to be able to read, remember and discover one day.',
                'type' => 'simple',
                'icon' => 'heroicon-o-sparkles',
                'color' => '#111111',
                'sort_order' => 3,
                'is_featured' => false,
            ],
            [
                'key' => 'consultant',
                'name' => 'Consultant',
                'article' => 'a',
                'short_description' => 'Ideas, conversations and time made available to others.',
                'description' => 'Bookable consulting time for people who need an experienced second brain.',
                'type' => 'simple',
                'icon' => 'heroicon-o-light-bulb',
                'color' => '#111111',
                'sort_order' => 4,
                'is_featured' => false,
            ],
            [
                'key' => 'entrepreneur',
                'name' => 'Entrepreneur',
                'article' => 'an',
                'short_description' => 'Building, investing in and experimenting with businesses.',
                'description' => 'A collection of ventures, products and experiments.',
                'type' => 'rich',
                'icon' => 'heroicon-o-rocket-launch',
                'color' => '#111111',
                'sort_order' => 5,
                'is_featured' => true,
            ],
            [
                'key' => 'writer',
                'name' => 'Writer',
                'article' => 'a',
                'short_description' => 'Books and articles about ideas worth exploring.',
                'description' => 'Long-form thinking, essays, experiments and books.',
                'type' => 'rich',
                'icon' => 'heroicon-o-pencil-square',
                'color' => '#111111',
                'sort_order' => 6,
                'is_featured' => false,
            ],
            [
                'key' => 'trainer',
                'name' => 'Trainer',
                'article' => 'a',
                'short_description' => 'Designing learning experiences that actually change behaviour.',
                'description' => 'Courses and learning experiences built around practical transformation.',
                'type' => 'rich',
                'icon' => 'heroicon-o-academic-cap',
                'color' => '#111111',
                'sort_order' => 7,
                'is_featured' => false,
            ],
            [
                'key' => 'songwriter',
                'name' => 'Songwriter',
                'article' => 'a',
                'short_description' => 'Turning ideas, memories and feelings into songs.',
                'description' => 'Original songs, recordings and unfinished musical ideas.',
                'type' => 'rich',
                'icon' => 'heroicon-o-musical-note',
                'color' => '#111111',
                'sort_order' => 8,
                'is_featured' => false,
            ],
        ];

        $representatives = [
            'human' => [Habit::class => 'Habits'],
            'husband' => [WifeMessage::class => 'Wife Messages'],
            'father' => [DaughterMessage::class => 'Daughter Messages'],
            'consultant' => [BookableSlot::class => 'Bookable Slots'],
            'entrepreneur' => [Venture::class => 'Ventures'],
            'writer' => [
                Book::class => 'Books',
                Article::class => 'Articles',
            ],
            'trainer' => [Course::class => 'Courses'],
            'songwriter' => [Song::class => 'Songs'],
        ];

        foreach ($roles as $roleData) {
            $role = MyRole::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'key' => $roleData['key'],
                ],
                $roleData
            );

            foreach ($representatives[$roleData['key']] as $modelType => $label) {
                MyRoleRepresentative::updateOrCreate(
                    [
                        'my_role_id' => $role->id,
                        'model_type' => $modelType,
                    ],
                    [
                        'label' => $label,
                        'sort_order' => array_search($modelType, array_keys($representatives[$roleData['key']]), true) + 1,
                        'is_primary' => array_key_first($representatives[$roleData['key']]) === $modelType,
                        'configuration' => null,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Human: Habits (25)
        |--------------------------------------------------------------------------
        */

        $habits = [
            ['Read', 'Read for at least 20 minutes.', 'daily', 20],
            ['Write', 'Write something every day.', 'daily', 1],
            ['Walk', 'Take a proper walk outside.', 'daily', 1],
            ['Exercise', 'Do a short workout.', 'daily', 1],
            ['Stretch', 'Stretch for ten minutes.', 'daily', 10],
            ['Meditate', 'Spend a few quiet minutes without screens.', 'daily', 10],
            ['Drink Water', 'Keep hydration intentional.', 'daily', 6],
            ['Plan Tomorrow', 'Write down the three most important things for tomorrow.', 'daily', 1],
            ['Journal', 'Capture the day in a few sentences.', 'daily', 1],
            ['Learn Something', 'Study something useful for at least 20 minutes.', 'daily', 20],
            ['Family Time', 'Spend uninterrupted time with family.', 'daily', 30],
            ['No Phone at Dinner', 'Keep phones away during dinner.', 'daily', 1],
            ['Review Finances', 'Review personal finances and upcoming expenses.', 'weekly', 1],
            ['Long Walk', 'Take a longer walk without multitasking.', 'weekly', 1],
            ['Call Parents', 'Call or meaningfully speak with parents.', 'weekly', 1],
            ['Weekly Review', 'Review what worked and what did not.', 'weekly', 1],
            ['Plan Week', 'Plan the coming week before it begins.', 'weekly', 1],
            ['Digital Cleanup', 'Clean up unnecessary files, messages and tabs.', 'weekly', 1],
            ['Creative Session', 'Make time for an original creative activity.', 'weekly', 1],
            ['Read Long Form', 'Read one substantial essay or chapter.', 'weekly', 1],
            ['Monthly Reflection', 'Reflect on the month and record lessons.', 'monthly', 1],
            ['Try Something New', 'Do one unfamiliar thing each month.', 'monthly', 1],
            ['Declutter', 'Remove things that no longer deserve space.', 'monthly', 1],
            ['Goal Review', 'Review progress against longer-term goals.', 'monthly', 1],
            ['Personal Reset', 'Take a deliberate half-day to reset and think.', 'monthly', 1],
        ];

        $habitModels = [];

        foreach ($habits as $index => [$name, $description, $frequency, $target]) {
            $habit = Habit::updateOrCreate(
                ['user_id' => $user->id, 'name' => $name],
                [
                    'description' => $description,
                    'frequency' => $frequency,
                    'target' => $target,
                    'start_date' => Carbon::today()->subDays(90 - $index),
                    'end_date' => null,
                    'active' => true,
                ]
            );

            $habitModels[] = $habit;
        }

        /*
        |--------------------------------------------------------------------------
        | Husband: Wife Messages (25)
        |--------------------------------------------------------------------------
        */

        $wifeMessages = [
            ['This means love', 'Love is rarely one grand gesture. It is all the tiny decisions to choose each other again.', 'love'],
            ['Thank you for today', 'Thank you for everything you do that nobody else sees.', 'gratitude'],
            ['You make home feel like home', 'There are places we live, and there are places where we belong. You made ours the second kind.', 'love'],
            ['Remember our beginning', 'We started with two people who had no idea how much life they would eventually share.', 'memory'],
            ['I still choose you', 'Even after ordinary days, difficult days and absurd days, I still choose you.', 'love'],
            ['For the hard days', 'You do not have to have everything figured out today.', 'support'],
            ['A quiet thank you', 'Some of my favourite moments are the ones nobody would think to photograph.', 'gratitude'],
            ['You make me laugh', 'Thank you for making ordinary life considerably less boring.', 'humour'],
            ['Our little rituals', 'The small routines we built together are part of the architecture of our life.', 'memory'],
            ['When you doubt yourself', 'You are far more capable than the voice in your head sometimes suggests.', 'support'],
            ['I notice', 'I notice the small things you do for us, even when I fail to say it.', 'gratitude'],
            ['Another year together', 'Another year means another collection of ordinary moments that somehow became our life.', 'anniversary'],
            ['A promise', 'I will keep trying to be the person you deserve beside you.', 'promise'],
            ['Our next adventure', 'There is still a lot of life left to discover together.', 'future'],
            ['Sunday morning', 'There is something wonderful about nowhere to be and nowhere else to belong.', 'memory'],
            ['Thank you for believing', 'Your belief has carried me through more than you probably realise.', 'gratitude'],
            ['For when life is chaotic', 'We do not need a perfect life. We need a life that is ours.', 'support'],
            ['One of my favourite things', 'My favourite thing about us is that we can turn almost anything into a story.', 'love'],
            ['You are my teammate', 'Life is easier when the person beside you is also the person in your corner.', 'love'],
            ['A future note', 'Whatever the next chapter brings, I want to read it with you.', 'future'],
            ['For an ordinary Tuesday', 'Nothing special happened today. That is sometimes the point.', 'memory'],
            ['You are enough', 'You do not have to earn your place in this family. You already belong here.', 'support'],
            ['Thank you for the patience', 'Thank you for the patience you have shown when I was not particularly easy to live with.', 'gratitude'],
            ['Still laughing', 'Years later, I am still grateful that you are the person I get to annoy every day.', 'humour'],
            ['Just because', 'No occasion. No reason. Just a reminder that I love you.', 'love'],
        ];

        foreach ($wifeMessages as $index => [$title, $message, $type]) {
            WifeMessage::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'message' => $message,
                    'type' => $type,
                    'message_date' => Carbon::today()->subDays(24 - $index),
                    'delivered_at' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Father: Daughter Messages (25)
        |--------------------------------------------------------------------------
        */

        $daughterMessages = [
            ['For when you are four', 'You are already funny, stubborn, curious and completely yourself. Protect that.', 4, 'birthday'],
            ['For your first big school day', 'You do not need to be the bravest person in the room. Just be willing to try.', 5, 'milestone'],
            ['For when you make a mistake', 'Mistakes are evidence that you are doing things humans actually do: learning.', 6, 'life'],
            ['For when you feel small', 'Being small is not the same as being powerless.', 7, 'life'],
            ['For your first big disappointment', 'It will hurt. Let it hurt, then keep going.', 8, 'life'],
            ['For when you need courage', 'Courage is usually just doing the next thing while still being afraid.', 9, 'life'],
            ['For when you fall in love with something', 'Take it seriously. Curiosity can become a life.', 10, 'life'],
            ['For your first failure', 'Failure is information, not an identity.', 11, 'life'],
            ['For when you choose your friends', 'Choose people who make you more yourself, not less.', 12, 'life'],
            ['For your teenage years', 'I will not always understand your world, but I will always want to understand you.', 13, 'life'],
            ['For when you disagree with me', 'You are allowed to think differently from me. Please do.', 14, 'life'],
            ['For your first big dream', 'Dreams become useful when you are willing to work on them.', 15, 'dream'],
            ['For when you think you are not good enough', 'You do not need to be the best to deserve to be here.', 16, 'support'],
            ['For when you leave home', 'Go. Build your own life. Keep a key to ours.', 18, 'milestone'],
            ['For your first job', 'Work matters, but it is only one part of a life.', 18, 'life'],
            ['For when someone breaks your heart', 'Do not let one painful person become your definition of love.', 19, 'support'],
            ['For your twenties', 'You are allowed to change your mind about almost everything.', 20, 'life'],
            ['For when you become independent', 'Independence does not mean never needing anyone.', 21, 'life'],
            ['For a difficult decision', 'Ask which choice you would respect yourself for making ten years from now.', 22, 'advice'],
            ['For when you succeed', 'Enjoy it. Success is not improved by pretending it means nothing.', 23, 'celebration'],
            ['For when you fail again', 'The ability to begin again is one of the most valuable skills you can have.', 24, 'support'],
            ['For your wedding day', 'Choose someone who makes ordinary Tuesday nights worth having.', 25, 'milestone'],
            ['For when you become a parent', 'You will understand some things about me differently then. Be patient with yourself.', 30, 'milestone'],
            ['For much later', 'Whatever age you are when you read this, I hope you know how deeply you were loved.', 40, 'love'],
            ['For always', 'Being your father has been one of the great privileges of my life.', 50, 'love'],
        ];

        foreach ($daughterMessages as [$title, $message, $age, $occasion]) {
            DaughterMessage::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'message' => $message,
                    'message_date' => Carbon::today(),
                    'age_at_time' => $age,
                    'occasion' => $occasion,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Consultant: Bookable Slots (25)
        |--------------------------------------------------------------------------
        */

        $slotTypes = [
            'strategy', 'product', 'business', 'marketing', 'technology',
            'education', 'career', 'operations', 'branding', 'growth',
        ];

        $slotStart = Carbon::tomorrow()->setTime(9, 0);

        for ($i = 0; $i < 25; $i++) {
            $startsAt = $slotStart->copy()->addDays(intdiv($i, 4))->addHours(($i % 4) * 2);

            BookableSlot::updateOrCreate(
                ['user_id' => $user->id, 'starts_at' => $startsAt],
                [
                    'ends_at' => $startsAt->copy()->addHour(),
                    'status' => 'available',
                    'type' => $slotTypes[$i % count($slotTypes)],
                    'price' => [75, 100, 125, 150, 200][$i % 5],
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Entrepreneur: Ventures (25)
        |--------------------------------------------------------------------------
        */

        $ventures = [
            ['plan.gifts', 'A gift planning platform that helps people remember occasions and choose better gifts.', 'https://plan.gifts', 'active', 'product'],
            ['Juco', 'A platform helping parents create and preserve meaningful moments with their children.', 'https://juco.app', 'active', 'product'],
            ['EdVenture', 'A modern language education business focused on preparing students for the future.', 'https://edventure.ro', 'active', 'education'],
            ['Engeve', 'A platform for trainers, coaches and mentors built around structured learning experiences.', null, 'active', 'saas'],
            ['Contro', 'A standardized service marketplace for Romanian businesses.', null, 'active', 'saas'],
            ['impact.courses', 'Group-based courses built around commitments, accountability and completion.', 'https://impact.courses', 'active', 'education'],
            ['valid.guide', 'An impartial review platform for online courses and guides.', 'https://valid.guide', 'active', 'media'],
            ['Ticking Life', 'A book and companion app about living a life of checkboxes.', 'https://ticking.life', 'active', 'media'],
            ['NevoieDe', 'A platform for discovering and managing procurement and tender opportunities.', null, 'idea', 'marketplace'],
            ['BusinessIn', 'A business media and intelligence concept.', null, 'idea', 'media'],
            ['Multumesc.org', 'A directory of useful free services and resources.', null, 'idea', 'directory'],
            ['GRDNT', 'A digital public service concept for institutions.', null, 'idea', 'govtech'],
            ['SCL', 'A digital public service concept for schools.', null, 'idea', 'govtech'],
            ['CBNT', 'A digital public service concept for cabinets and public offices.', null, 'idea', 'govtech'],
            ['SPTL', 'A digital public service concept for local public services.', null, 'idea', 'govtech'],
            ['PRMR', 'A digital public service concept for municipalities.', null, 'idea', 'govtech'],
            ['Gifter Studio', 'A studio concept for tools that make gift planning easier.', null, 'exploring', 'product'],
            ['Parent Memory', 'A lightweight memory-journal concept for families.', null, 'exploring', 'product'],
            ['Course Builder', 'A tool for turning structured course ideas into reusable learning products.', null, 'exploring', 'saas'],
            ['Trainer OS', 'An operating system concept for independent trainers and coaches.', null, 'exploring', 'saas'],
            ['School Digital Checkup', 'A digital maturity assessment product for schools.', null, 'exploring', 'education'],
            ['Future Skills Lab', 'A learning concept focused on skills students will need in the future.', null, 'exploring', 'education'],
            ['Social Content Engine', 'A productized workflow for creating structured social content at scale.', null, 'exploring', 'saas'],
            ['Role Portfolio', 'The personal portfolio system represented by Conrad.Works.', null, 'active', 'software'],
            ['Conrad.Works', 'A personal operating system connecting identity, projects, work and creative output.', null, 'active', 'software'],
        ];

        foreach ($ventures as $index => [$name, $description, $url, $status, $type]) {
            Venture::updateOrCreate(
                ['user_id' => $user->id, 'slug' => str($name)->slug()],
                [
                    'name' => $name,
                    'description' => $description,
                    'url' => $url,
                    'status' => $status,
                    'type' => $type,
                    'started_at' => Carbon::today()->subMonths(36 - $index),
                    'ended_at' => null,
                    'featured' => in_array($index, [0, 1, 2, 5, 24], true),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Writer: Books (25)
        |--------------------------------------------------------------------------
        */

        $books = [
            ['Ticking Life', 'A Life of Checkboxes', 'An exploration of how productivity can become a substitute for actually living.', 'draft'],
            ['The Reinvention Experiment', '365 Days of Becoming Someone Else', 'A practical record of deliberately redesigning work, habits and identity.', 'draft'],
            ['The IMPACT Method', 'From Idea to Action', 'A framework for turning vague intentions into meaningful action.', 'draft'],
            ['The Future of Learning', 'Teaching Beyond the Classroom', 'How technology can improve learning without replacing teachers.', 'draft'],
            ['Parents for Parents', 'Things We Wish We Knew Earlier', 'A collection of practical lessons shared by parents.', 'concept'],
            ['The Human Operating System', 'Designing a Life That Works', 'A framework for thinking about personal systems without becoming a robot.', 'concept'],
            ['The Attention Economy', 'Why Everything Wants Your Focus', 'A guide to protecting attention in a world designed to capture it.', 'concept'],
            ['The Founder Notebook', 'Ideas, Experiments and Lessons', 'Notes from building many things at once.', 'concept'],
            ['Small Bets', 'A Practical Guide to Experiments', 'How to test ideas without betting your entire life on them.', 'concept'],
            ['The Course That Gets Finished', 'Designing for Completion', 'Why completion should be treated as a product feature.', 'concept'],
            ['Teaching Humans', 'Technology in Service of Students', 'A teacher-first view of educational technology.', 'concept'],
            ['The Language Advantage', 'Why Communication Beats Memorisation', 'A practical philosophy for language learning.', 'concept'],
            ['The Entrepreneurial Portfolio', 'Many Bets, One Life', 'How multiple ventures can coexist without becoming chaos.', 'concept'],
            ['The Good Enough Product', 'Build Before You Perfect', 'A practical case for shipping earlier.', 'concept'],
            ['No More Procrastination', '30 Days to Finish One Thing', 'A commitment-based approach to completing postponed work.', 'concept'],
            ['The Attention of Children', 'Designing Better Learning', 'Understanding attention as the starting point of education.', 'concept'],
            ['The Parent Archive', 'Preserving What Childhood Feels Like', 'Why memories need more than photos.', 'concept'],
            ['Letters to Ava', 'Notes for Later', 'A collection of messages written for a daughter to discover in the future.', 'concept'],
            ['The Consultant as Product', 'Packaging Expertise', 'How expertise can become a clear, bookable product.', 'concept'],
            ['Training in Five Acts', 'The 5D Method', 'Discover, Design, Deliver, Debrief and Demonstrate.', 'concept'],
            ['The Modern Language Centre', 'Beyond Courses and Classrooms', 'A new operating model for private language education.', 'concept'],
            ['Building in Public', 'The Useful Parts', 'A practical guide to sharing work without turning life into content.', 'concept'],
            ['The Family Business', 'Work, Love and Boundaries', 'Thoughts on running businesses while protecting family life.', 'concept'],
            ['The Project Garden', 'Growing Ideas Without Losing Yourself', 'A system for managing many projects without treating every idea as urgent.', 'concept'],
            ['One Year to Reinvent Yourself', 'Daily Experiments', 'Lessons from a year of deliberately changing direction.', 'concept'],
        ];

        foreach ($books as $index => [$title, $subtitle, $description, $status]) {
            Book::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'subtitle' => $subtitle,
                    'description' => $description,
                    'status' => $status,
                    'published_at' => null,
                    'isbn' => null,
                    'cover' => null,
                    'url' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Writer: Articles (25)
        |--------------------------------------------------------------------------
        */

        $articles = [
            ['Why I Am Building Conrad.Works', 'A personal operating system for a life with too many interesting directions.', 'Medium'],
            ['The One-Year Reinvention Experiment', 'What happens when you deliberately stop treating your current life as permanent.', 'Medium'],
            ['Courses You Start, Commitments You Complete', 'Why completion is a better measure of learning than content consumption.', 'Medium'],
            ['The Problem With Productivity', 'When doing more becomes a way of avoiding what actually matters.', 'Medium'],
            ['Technology Should Earn Its Place in Education', 'Technology is useful when it improves the student experience, not when it merely looks modern.', 'Medium'],
            ['Teachers Need Better Tools, Not More Dashboards', 'Why educational software should remove friction instead of creating reporting work.', 'Medium'],
            ['Attention Is the First Learning Outcome', 'Before students can learn, something has to earn their attention.', 'Medium'],
            ['Why Language Courses Fail Adults', 'The gap between knowing language and actually using it.', 'Medium'],
            ['The Future of the Language Centre', 'What a modern language business should look like.', 'Medium'],
            ['A Course Is Not a Curriculum', 'The difference between content architecture and an experience that produces change.', 'Medium'],
            ['The Case for T-Shirt Sized Courses', 'Why small, medium and large course commitments can make buying easier.', 'Medium'],
            ['Build the Product Around the Behaviour', 'Start with the action you want people to take, then design backward.', 'Medium'],
            ['Why I Keep Building Small Businesses', 'The logic behind a portfolio of experiments.', 'Medium'],
            ['The Personal Portfolio Is the New CV', 'Why a list of job titles tells less than a body of actual work.', 'Medium'],
            ['What Parents Actually Want to Remember', 'The difference between storing media and preserving meaning.', 'Medium'],
            ['The Internet Has Too Many Courses', 'The problem is not access to knowledge. It is action and completion.', 'Medium'],
            ['Procrastination Is Often a Design Problem', 'Why changing the environment can be more effective than demanding discipline.', 'Medium'],
            ['The Consultant Should Be Bookable', 'Turning expertise into something concrete and easy to buy.', 'Medium'],
            ['Five Dimensions of Better Training', 'A practical look at Discover, Design, Deliver, Debrief and Demonstrate.', 'Medium'],
            ['What Makes a Good Educational Product', 'Clarity, relevance, feedback, practice and a reason to continue.', 'Medium'],
            ['A Better Way to Think About Side Projects', 'Projects need stages, not permanent emotional commitment.', 'Medium'],
            ['The Difference Between an Idea and a Venture', 'An idea becomes real when it has a user, a problem and a next action.', 'Medium'],
            ['Why Family Memories Need Context', 'A photograph preserves an instant. A story preserves why it mattered.', 'Medium'],
            ['Building a Life in Public', 'What is worth sharing and what should remain private.', 'Medium'],
            ['What I Learned From Building Too Many Things', 'A brutally practical inventory of patterns, mistakes and useful constraints.', 'Medium'],
        ];

        foreach ($articles as $index => [$title, $excerpt, $publication]) {
            Article::updateOrCreate(
                ['user_id' => $user->id, 'slug' => str($title)->slug()],
                [
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'body' => $excerpt . "\n\nThis is seeded demonstration content for Conrad.Works.",
                    'published_at' => Carbon::now()->subDays(25 - $index),
                    'status' => 'published',
                    'publication' => $publication,
                    'url' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Trainer: Courses (25)
        |--------------------------------------------------------------------------
        */

        $courses = [
            ['30 Days Without Procrastination', 'Complete one important postponed project in 30 days.', 'active', '30 days', 49, 'Adults'],
            ['The IMPACT Method', 'Turn ideas into concrete action using a repeatable framework.', 'active', '2 days', 149, 'Entrepreneurs'],
            ['Future Skills for Students', 'Build the habits and skills needed for a changing world.', 'active', '8 weeks', 199, 'Students'],
            ['Better Presentations', 'Create and deliver presentations people actually remember.', 'active', '4 weeks', 129, 'Professionals'],
            ['Strategic Thinking', 'Learn to see systems, trade-offs and second-order effects.', 'active', '4 weeks', 179, 'Managers'],
            ['Communication That Works', 'Practice clear communication across everyday situations.', 'active', '4 weeks', 149, 'Professionals'],
            ['Train the Trainer', 'Design practical learning experiences from scratch.', 'active', '6 weeks', 249, 'Trainers'],
            ['The 5D Training Method', 'Discover, Design, Deliver, Debrief and Demonstrate.', 'active', '5 weeks', 229, 'Trainers'],
            ['AI for Teachers', 'Use AI to save time and improve student learning.', 'active', '3 weeks', 99, 'Teachers'],
            ['AI for Course Creators', 'Turn expertise into scalable learning products.', 'active', '4 weeks', 149, 'Creators'],
            ['Build Your First Digital Product', 'Go from problem to first usable product.', 'active', '30 days', 199, 'Entrepreneurs'],
            ['Personal Productivity Without the Hustle', 'Build systems that support work without consuming life.', 'active', '14 days', 79, 'Professionals'],
            ['Design Better Habits', 'Build habits around environment, cues and feedback.', 'active', '21 days', 69, 'Adults'],
            ['Strategic Planning for Small Business', 'Create a practical plan you can actually execute.', 'active', '2 days', 179, 'Business owners'],
            ['Customer Discovery', 'Learn what people actually need before building.', 'active', '2 weeks', 119, 'Founders'],
            ['Product Positioning', 'Make the value of a product immediately understandable.', 'active', '2 weeks', 119, 'Founders'],
            ['Social Content Systems', 'Create a repeatable content engine without daily panic.', 'active', '14 days', 89, 'Creators'],
            ['Writing Online', 'Develop a consistent system for publishing useful ideas.', 'active', '30 days', 79, 'Writers'],
            ['Storytelling for Business', 'Use stories to make ideas easier to understand and remember.', 'active', '3 weeks', 129, 'Professionals'],
            ['Leadership Through Questions', 'Use better questions to help people think and act.', 'draft', '4 weeks', 149, 'Leaders'],
            ['Running Effective Workshops', 'Plan, facilitate and debrief workshops that produce outcomes.', 'draft', '3 weeks', 159, 'Facilitators'],
            ['Language Learning for Busy Adults', 'Build a practical language routine around real communication.', 'draft', '30 days', 69, 'Adults'],
            ['Building a Learning Community', 'Create accountability without turning learning into competition.', 'draft', '4 weeks', 129, 'Educators'],
            ['The Modern Consultant', 'Package expertise into clear offers and bookable sessions.', 'draft', '3 weeks', 149, 'Consultants'],
            ['Finish What You Start', 'A practical system for reducing open loops and completing meaningful work.', 'draft', '21 days', 69, 'Adults'],
        ];

        foreach ($courses as [$title, $description, $status, $duration, $price, $audience]) {
            Course::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'description' => $description,
                    'status' => $status,
                    'duration' => $duration,
                    'price' => $price,
                    'audience' => $audience,
                    'image' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Songwriter: Songs (25)
        |--------------------------------------------------------------------------
        */

        $songs = [
            ['Home Is You', 'A song about finding home in a person.', 'draft'],
            ['Small Things', 'A song about the ordinary moments that become memories.', 'draft'],
            ['Four Years Old', 'A song about watching a child become a person.', 'draft'],
            ['Tomorrow Will Come', 'A hopeful song about difficult seasons passing.', 'draft'],
            ['Still Here', 'A song about staying when life gets complicated.', 'draft'],
            ['One More Day', 'A reflective song about choosing another day together.', 'draft'],
            ['The Way You Laugh', 'A playful song built around a favourite laugh.', 'draft'],
            ['Photographs Lie', 'A song about the difference between pictures and memories.', 'draft'],
            ['Before We Knew', 'A song about the early days before we knew where life would lead.', 'draft'],
            ['Ordinary Magic', 'A song about finding wonder in routine family life.', 'draft'],
            ['Letters for Later', 'A song written as a message to a child in the future.', 'draft'],
            ['The Long Way Home', 'A reflective song about choosing a slower life.', 'draft'],
            ['Keep Dancing', 'A song about holding on to joy.', 'draft'],
            ['When We Are Old', 'A song imagining the stories that survive decades.', 'draft'],
            ['No Perfect Life', 'A song about accepting an imperfect but meaningful life.', 'draft'],
            ['You Made This Place', 'A song about how people create the feeling of home.', 'draft'],
            ['The Things I Forget to Say', 'A collection of gratitude that usually remains unsaid.', 'draft'],
            ['A Better Tomorrow', 'A hopeful song about building rather than waiting.', 'draft'],
            ['The Road Ahead', 'A song about choosing uncertainty deliberately.', 'draft'],
            ['Stay Curious', 'A song about keeping curiosity alive.', 'draft'],
            ['Our Little World', 'A family song about the private universe people build together.', 'draft'],
            ['One Hundred Sundays', 'A song about ordinary weekends becoming a lifetime.', 'draft'],
            ['Nothing to Prove', 'A song about being enough without external validation.', 'draft'],
            ['The Next Chapter', 'A song about starting again.', 'draft'],
            ['Vivo in the Moment', 'An original song concept about noticing life while it happens.', 'draft'],
        ];

        foreach ($songs as $index => [$title, $description, $status]) {
            Song::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'lyrics' => null,
                    'description' => $description,
                    'status' => $status,
                    'written_at' => Carbon::today()->subDays(25 - $index),
                    'recording' => null,
                    'audio' => null,
                    'cover' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Habit Completions (25)
        |--------------------------------------------------------------------------
        |
        | One completion per seeded habit keeps the unique(habit_id, completed_on)
        | constraint happy while giving the resource meaningful data.
        |
        */

        foreach (array_slice($habitModels, 0, 25) as $index => $habit) {
            HabitCompletion::updateOrCreate(
                [
                    'habit_id' => $habit->id,
                    'completed_on' => Carbon::today()->subDays($index),
                ],
                [
                    'notes' => [
                        'Good start.',
                        'Completed before work.',
                        'Kept it simple.',
                        'Felt easier today.',
                        'Worth repeating.',
                    ][$index % 5],
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Bookings (25)
        |--------------------------------------------------------------------------
        |
        | Each BookableSlot can have only one booking, so use the first 25
        | available slots and create one booking for each.
        |
        */

        $slots = BookableSlot::query()
            ->where('user_id', $user->id)
            ->orderBy('starts_at')
            ->limit(25)
            ->get();

        foreach ($slots as $index => $slot) {
            Booking::updateOrCreate(
                ['bookable_slot_id' => $slot->id],
                [
                    'name' => 'Client ' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'email' => 'client' . ($index + 1) . '@example.com',
                    'notes' => 'Seeded consultation booking.',
                    'status' => $index % 5 === 0 ? 'confirmed' : 'pending',
                    'booked_at' => Carbon::now()->subDays($index),
                ]
            );

            $slot->update([
                'status' => $index % 5 === 0 ? 'booked' : 'reserved',
            ]);
        }
    }
}
