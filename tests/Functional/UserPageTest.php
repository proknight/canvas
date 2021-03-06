<?php

class UserPageTest extends TestCase
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
    public function it_can_refresh_the_user_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/user')
            ->click('Refresh Users');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/user');
    }

    /** @test */
    public function it_cannot_access_the_user_page_if_user_is_not_an_admin()
    {
        $this->user['role'] = 0;
        $this->actingAs($this->user)->visit('/admin/user');
        $this->seePageIs('/admin');
        $this->assertSessionMissing('errors');
    }
}
