<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl  text-center font-semibold mb-8">Complete la información para crear un producto</h1>

    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- Categoria --}}
        <div>
            <x-jet-label value="Categorias" />
            <select class="w-full form-control" wire:model="category_id">
                <option value="" selected disabled hidden>Seleccione una categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="category_id"/>
        </div>

        {{-- Subcategoria --}}
        <div>
            <x-jet-label value="Subcategorias" />
            <select class="w-full form-control" wire:model="subcategory_id">
                <option value="" selected disabled hidden>Seleccione una subcategoria</option>
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="subcategory_id"/>
        </div>
    </div>

    {{-- Nombre del producto --}}
    <div class="mb-4">
        <x-jet-label value="Nombre" class="w-full"/>
        <x-jet-input wire:model="name" type="text" class="w-full" placeholder="Ingrese el nombre del producto"/>
        <x-jet-input-error for="name"/>
    </div>
    
    {{-- Slug --}}
    <div class="mb-4">
        <x-jet-label value="Nombre" class="w-full"/>
        <x-jet-input wire:model="slug" type="text" disabled class="w-full bg-gray-200" placeholder="Ingrese el nombre del producto"/>
        <x-jet-input-error for="slug"/>
    </div>
    
    {{-- Description --}}
    <div class="mb-4">
        <div wire:ignore>
            <x-jet-label value="Descriptión" />
            <textarea class="w-full form-control"
                rows="4" 
                wire:model="description"
                x-data
                x-init="ClassicEditor.create( $refs.miEditor)
                .then(function(editor){
                    editor.model.document.on('change:data', () => {
                        @this.set('description', editor.getData())
                    })
                })
                .catch( error => {
                    console.error( error );
                } );"
                x-ref="miEditor">
            </textarea>
        </div>
        <x-jet-input-error for="description"/>
    </div>

    <div class="mb-4 grid grid-cols-2 gap-6">
        {{-- Brand --}}
        <div>
            <x-jet-label value="Marca" />
            <select wire:model="brand_id" class="form-control w-full">
                <option value="" selected disabled hidden>Seleccione una marca</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="brand_id"/>
        </div>
        {{-- Price --}}
        <div>
            <x-jet-label value="Precio" />
            <x-jet-input wire:model="price" type="number" class="w-full" step="0.1"/>
            <x-jet-input-error for="price"/>
        </div>
    </div>

    <div>
        @if($subcategory_id)
            @if (!$this->subcategory->color && !$this->subcategory->size)
                <x-jet-label value="Stock" />
                <x-jet-input wire:model="qty" type="number" class="w-full"/>
                <x-jet-input-error for="qty"/>
            @endif
        @endif
    </div>

    <div class="flex">
        <x-jet-button 
            class="ml-auto" 
            wire:click="saveProduct"
            wire:loading.attr="disable"
            wire:target="saveProduct"> 
            Guardar producto 
        </x-jet-button>
    </div>
</div>
