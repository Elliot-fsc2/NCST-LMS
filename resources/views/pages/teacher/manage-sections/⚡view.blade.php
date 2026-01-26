<?php

use Livewire\Component;
use App\Models\Section;

new class extends Component {
    public Section $section;

};
?>

<x-slot name="title">{{ $section->name }}</x-slot>
<x-slot name="header">{{ $section->name }}</x-slot>

<div>
</div>
