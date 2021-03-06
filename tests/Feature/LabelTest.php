<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function testIndex(): void
    {
        $this->get(route('labels.index'))
             ->assertSessionHasNoErrors()
             ->assertOk();
    }
    /* ------- Test actions as guest --------- */

    public function testCreateAsGuest(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(403);
    }

    public function testStoreAsGuest(): void
    {
        $label = make(Label::class)->make()->toArray();
        $this->post(route('labels.store', $label))
            ->assertStatus(403);
        $this->assertDatabaseMissing('labels', $label);
    }

    public function testUpdateAsGuest(): void
    {
        $label = make(Label::class)->create();
        $this->get(route('labels.edit', $label))
             ->assertStatus(403);
        $this->patch(route('labels.update', $label), ['name' => 'new name'])
             ->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', ['name' => 'new name']);
    }

    public function testDeleteAsGuest(): void
    {
        $label = make(Label::class)->create();
        $this->delete(route('labels.destroy', $label))
             ->assertStatus(403);
        $this->assertDatabaseHas('labels', ['id' => $label->only('id')]);
    }

    /* ------ Test actions as user ------- */

    public function testStoreAsUser(): void
    {
        $label = make(Label::class)->make()->toArray();
        $this->actingAs($this->user)
             ->post(route('labels.store'), $label)
             ->assertSessionHasNoErrors()
             ->assertRedirect();
        $this->assertDatabaseHas('labels', $label);

        $this->get(route('labels.index'))
            ->assertSeeText('Метка успешно создана');
    }

    public function testUpdateAsUser(): void
    {
        $newName = ['name' => 'Updated'];
        $label = make(Label::class)->create();
        $this->actingAs($this->user)
             ->patch(route('labels.update', $label), $newName)
             ->assertRedirect(route('labels.index'))
             ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $newName);

        $this->get(route('labels.index'))
            ->assertSeeText('Метка успешно изменена');
    }

    public function testDeleteAsUser(): void
    {
        $label = make(Label::class)->create();
        $this->actingAs($this->user)
             ->delete(route('labels.update', $label))
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('labels.index'));

        $this->get(route('labels.index'))
             ->assertSeeText('Метка успешно удалена');

        $this->assertDatabaseMissing('labels', ['name' => $label->only('name')]);
    }

    public function testDeleteLabelAttachedWithTheTask(): void
    {
        $label = make(Label::class)
             ->hasAttached(Task::factory()->count(1))->create();

        $this->actingAs($this->user);
        $this->delete(route('labels.destroy', $label))
             ->assertRedirect();

        $this->get(route('labels.index'))
             ->assertSeeText('Не удалось удалить метку');

        $this->assertDatabaseHas('labels', ['name' => $label->only('name')]);
    }
}
