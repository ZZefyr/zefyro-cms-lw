<div class="project-settings mb-6">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-form-input
                            label="Titulek stránky"
                            name="title"
                            wire:model="title"
                            :error="$errors->first('title')"
                            required
                        />
                        <x-form-textarea
                            label="Meta popis"
                            name="metaDescription"
                            wire:model="metaDescription"
                            :error="$errors->first('metaDescription')"
                            required
                        />
                    </div>
                    <div>
                        <x-form-input
                            label="Email"
                            name="email"
                            wire:model="email"
                            :error="$errors->first('email')"
                            required
                        />
                    </div>
                    <div>
                        <x-form-input
                            label="Heslo"
                            name="password"
                            type="password"
                            wire:model="password"
                            :error="$errors->first('password')"
                            required
                        />
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary">Uložit změny</button>
                </div>
            </form>
        </div>
    </div>
</div>
