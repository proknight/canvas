<?php

class HomePageTest extends TestCase
{
    use InteractsWithDatabase;

    /**
     * The user model.
     *
     * @var App\Models\User
     */
    private $user;

    /**
     * Create the user model test subject.
     *
     * @before
     * @return void
     */
    public function createUser()
    {
        $this->user = factory(App\Models\User::class)->create();
    }

    /** @test */
    public function it_can_preview_the_blog_from_the_home_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin')
            ->click('View Site');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/');
    }

    /** @test */
    public function it_displays_all_cards_if_user_is_an_admin()
    {
        $this->actingAs($this->user)
            ->visit('/admin')
            ->see('Welcome to Canvas!')
            ->see('At a Glance');
        $this->assertSessionMissing('errors');
    }

    /** @test */
    public function it_does_not_display_all_cards_if_user_is_not_an_admin()
    {
        $this->user['role'] = 0;
        $this->actingAs($this->user)
            ->visit('/admin')
            ->dontSee('Welcome to Canvas!')
            ->dontSee('At a Glance');
        $this->assertSessionMissing('errors');
    }
}
