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
        </div>
    </div>

    {{-- Nombre del producto --}}
    <div class="mb-4">
        <x-jet-label value="Nombre" class="w-full"/>
        <x-jet-input wire:model="name" type="text" class="w-full" placeholder="Ingrese el nombre del producto"/>
    </div>
    
    {{-- Slug --}}
    <div class="mb-4">
        <x-jet-label value="Nombre" class="w-full"/>
        <x-jet-input wire:model="slug" type="text" disabled class="w-full bg-gray-200" placeholder="Ingrese el nombre del producto"/>
    </div>
    
    {{-- Description --}}
    <div class="mb-4" wire:ignore>
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
            x-ref="miEditor"></textarea>
    </div>

    <div class="mb-4">
        <x-jet-label value="Marca" />
        <select wire:model="brand_id" class="form-control w-full">
            <option value="" selected disabled hidden>Seleccione una marca</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
</div>
