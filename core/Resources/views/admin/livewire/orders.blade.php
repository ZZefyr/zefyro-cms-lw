<div>
    <x-slot:title>Objednávky</x-slot:title>
    <p>Vítejte v nastavení uživatelů!</p>
    <div class="stats">
        <p>Uživatelé: {{ $this->stats['users'] }}</p>
        <p>Objednávky: {{ $this->stats['orders'] }}</p>
        <p>Tržby: {{ $this->stats['revenue'] }}</p>
    </div>
</div>

{{-- Obsah pro sidebar slot --}}
<x-slot:sidebar>
    <div>
        <h3>Rychlé akce</h3>
        <ul>
            <li>Nový příspěvek</li>
            <li>Statistiky</li>
        </ul>
    </div>
</x-slot:sidebar>

{{-- Obsah pro footer slot --}}
<x-slot:footer>
    <p>© 2025 Admin panel</p>
</x-slot:footer>
