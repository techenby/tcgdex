<?php

namespace App\Livewire\Forms;

use App\PtcgoImporter;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DeckForm extends Form
{
    #[Validate('required|min:5')]
    public $name = '';

    public $notes = '';

    public function store()
    {
        $this->validate();

        $deck = auth()->user()->decks()->create([
            'name' => $this->name,
        ]);

        if (! empty($this->notes)) {
            $cards = PtcgoImporter::getCards($this->notes);
            $deck->cards()->attach($cards);
        }
    }
}
