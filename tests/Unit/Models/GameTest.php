<?php

namespace Tests\Unit\Models;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use App\ValueObjects\DateRange;
use Database\Seeders\GamesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    private readonly Game $game;
    private readonly User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GamesSeeder::class);

        $this->game = Game::where('name', 'PAYDAY 2')->first();
        $this->user = User::factory()->create();
    }

    /** @dataProvider categoryProvider */
    public function test_reviewResults_works(string $category, int $quantityOfReviews, int $grade): void
    {
        for ($i = 0; $i < $quantityOfReviews; $i++) {
            Review::factory()->create([
                'game_id' => $this->game->id,
                'user_id' => $this->user->id,
                $category => $grade
            ]);
        }

        $reviews = $this->game->reviewResults();

        self::assertSame($quantityOfReviews, $reviews['all']);
        self::assertSame($grade, $reviews['reviews'][$category]);
    }

    public function categoryProvider(): array
    {
        return [
            ['general', 10, 10],
            ['atmosphere', 25, 7],
            ['unique', 15, 3],
        ];
    }

    /** @dataProvider bestCategoryProvider */
    public function test_getBestAndGeneralReviews_works(
        string $category,
        int $quantityOfReviews,
        int $generalGrade,
        int $grade
    ): void {
        $categories = [
            'game_id' => $this->game->id,
            'user_id' => $this->user->id,
            'music' => 1,
            'graphic' => 1,
            'atmosphere' => 1,
            'difficulty' => 1,
            'storyline' => 1,
            'relaxation' => 1,
            'pleasure' => 1,
            'child-friendly' => 1,
            'NSFW' => 1,
            'gore' => 1,
            'unique' => 1,
            'general' => $generalGrade,
        ];

        $categories[$category] = $grade;

        for ($i = 0; $i < $quantityOfReviews; $i++) {
            Review::factory()->create($categories);
        }

        $reviews = $this->game->getBestAndGeneralReviews();

        self::assertSame($quantityOfReviews, $reviews['allReviews']);
        self::assertSame((float) $generalGrade, $reviews['general']);
        self::assertSame((float) $grade, $reviews['best']['score']);
        self::assertSame($category, $reviews['best']['name']);
    }

    public function bestCategoryProvider(): array
    {
        return [
            ['general', 10, 10, 10],
            ['atmosphere', 25, 8, 9],
            ['unique', 15, 2, 3],
        ];
    }

    public function test_wasReviewedBy_works(): void
    {
        Review::factory()->create([
            'game_id' => $this->game->id,
            'user_id' => $this->user->id,
        ]);

        $newUser = User::factory()->create();

        self::assertTrue($this->game->wasReviewedBy($this->user->id));
        self::assertFalse($this->game->wasReviewedBy($newUser->id));
    }

    public function test_isReleased(): void
    {
        self::assertTrue($this->game->isReleased());
    }

    /** @dataProvider dataRangeProvider */
    public function test_isInDateRange(
        DateRange $range,
        bool $shouldBeInDateRange,
    ): void {
        self::assertSame($shouldBeInDateRange, $this->game->isInDateRange($range));
    }

    //13 august 2013
    public function dataRangeProvider(): array
    {
        return [
            [
                new DateRange(null, null), true
            ],
            [
                new DateRange('2013', null), true
            ],
            [
                new DateRange(null, '2013'), true
            ],
            [
                new DateRange('2012', null), true
            ],
            [
                new DateRange(null, '2014'), true
            ],
            [
                new DateRange(null, '2012'), false
            ],
            [
                new DateRange('2014', null), false
            ],
        ];
    }
}
