<section id="stats">
<h1 class="text-2xl font-bold mb-4">Dashboard</h1>
<div class="stats grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="stat bg-blue-100 p-4 rounded">
        <h2 class="text-lg font-semibold">Uživatelé</h2>
        <p class="text-3xl">{{ $this->stats['users'] }}</p>
    </div>
    <div class="stat bg-green-100 p-4 rounded">
        <h2 class="text-lg font-semibold">Objednávky</h2>
        <p class="text-3xl">{{ $this->stats['orders'] }}</p>
    </div>
    <div class="stat bg-yellow-100 p-4 rounded">
        <h2 class="text-lg font-semibold">Tržby</h2>
        <p class="text-3xl">{{ $this->stats['revenue'] }}</p>
    </div>
</div>
</section>
