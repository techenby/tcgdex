<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DeckForm extends Form
{
    #[Validate('required|min:5')]
    public $name = '';

    #[Validate('required|min:5')]
    public $notes = '';

    public function store()
    {
        $this->validate();

        $deck = auth()->user()->decks()->create([
            'name' => $this->name,
             'notes' => $this->notes,
        ]);

        dd($deck);
    }
}
