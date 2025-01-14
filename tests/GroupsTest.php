<?php

class GroupsTest extends GroupsTestCase
{
    public $groupData;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUsers();

        $this->groupData = ['name' => 'Lorem'];
    }

    /** @test * */
    public function it_creates_a_group()
    {
        Groups::create($this->user->id, $this->groupData);

        $this->assertDatabaseHas('groups', ['id' => 1]);
    }

    /** @test * */
    public function it_can_delete_a_group()
    {
        $user = $this->createUsers();

        $group = Groups::create($user->id, $this->groupData);

        $this->assertDatabaseHas('groups', ['id' => 1]);

        $group->delete();

        $this->assertDatabaseMissing('groups', ['id' => 1]);
    }

    /** @test * */
    public function it_can_update_a_group()
    {
        $user = $this->createUsers();

        $group = Groups::create($user->id, $this->groupData);

        $this->groupData['name'] = 'Ipsum';

        $group->update($this->groupData);

        $this->assertDatabaseHas('groups', ['id' => 1, 'name' => 'Ipsum']);
    }

    /** @test */
    public function it_can_return_a_user_instance()
    {
        $user = Groups::getUser(1);

        $this->assertEquals(1, $user->id);
    }

    /** @test * */
    public function it_can_add_members_to_group()
    {
        $users = $this->createUsers(4);

        $group = Groups::create($users[0]->id, $this->groupData);

        $group->addMembers([$users[1]->id, $users[2]->id]);

        $this->assertEquals(2, $group->fresh()->users->count());
    }

    /** @test * */
    public function it_can_create_group_stat()
    {
        $user = $this->createUsers();
        $group = Groups::create($user->id, $this->groupData);

        $this->assertDatabaseHas('group_stats', ['group_id' => $group->id]);

    }


    /** @test * */
    public function it_can_make_a_group_request()
    {
        $group = Groups::create($this->user->id, $this->groupData);

        $users = $this->createUsers(4);

        $group->request($users[1]->id);

        $this->assertDatabaseHas('group_request', ['group_id' => $group->id, 'user_id' => $users[1]->id]);
    }

    /** @test * */
    public function it_can_accept_a_group_request()
    {
        $group = Groups::create($this->user->id, $this->groupData);

        $users = $this->createUsers(4);

        $group->request($users[1]->id);

        $group->acceptRequest($users[1]->id);

        $this->assertEquals(2, $group->fresh()->users->count());

        $this->assertDatabaseMissing('group_request', ['group_id' => $group->id, 'user_id' => $users[1]->id]);
    }

    /** @test * */
    public function it_can_decline_a_group_request()
    {
        $group = Groups::create($this->user->id, $this->groupData);

        $users = $this->createUsers(4);

        $group->request($users[1]->id);

        $group->declineRequest($users[1]->id);

        $this->assertDatabaseMissing('group_request', ['group_id' => $group->id, 'user_id' => $users[1]->id]);
    }

    /** @test * */
    public function it_can_tell_how_many_groups_a_user_is_member_of()
    {
        $users = $this->createUsers(4);

        $group = Groups::create($this->user->id, $this->groupData);
        $group1 = Groups::create($this->user->id, $this->groupData);

        $group->request($users[1]->id);
        $group->acceptRequest($users[1]->id);

        $group1->request($users[1]->id);
        $group1->acceptRequest($users[1]->id);

        $u = Mohiqssh\Groups\Models\User::find($users[1]->id);

        $this->assertEquals(2, $u->groups->count());
    }

    /** @test * */
    public function it_can_remove_members_in_group()
    {
        $users = $this->createUsers(4);

        $group = Groups::create($users[0]->id, $this->groupData);

        $group->addMembers([$users[1]->id, $users[2]->id]);

        $this->assertEquals($group->fresh()->users->count(), 2);

        $group->leave([$users[2]->id]);

        $this->assertEquals(1, $group->fresh()->users->count());
    }
}
