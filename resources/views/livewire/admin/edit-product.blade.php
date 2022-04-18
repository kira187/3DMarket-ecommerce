<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl  text-center font-semibold mb-8">Complete la información para crear un producto</h1>

    <div class="card mb-4 p-6" wire:ignore>
        <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone" id="my-awesome-dropzone"> </form>
    </div>

    @if (count($product->images))
        <section class="card p-6 mb-4">
            <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>
            <ul class="flex flex-wrap">
                @foreach ($product->images as $imagen)
                    <li class="relative" wire:key="image-{{ $imagen->id }}">
                        <img src="{{ Storage::url($imagen->url)}}" class="w-32 h-20 object-cover">
                        <x-jet-danger-button 
                            class="absolute right-2 top-2" 
                            wire:click="deleteImage({{ $imagen->id }})"
                            wire:loading.attr="disabled"
                            wire:target="deleteImage({{ $imagen->id }})"> 
                            x 
                        </x-jet-danger-button>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <div class="card p-6">
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
                <select class="w-full form-control" wire:model="product.subcategory_id">
                    <option value="" selected disabled hidden>Seleccione una subcategoria</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="product.subcategory_id"/>
            </div>
        </div>
    
        {{-- Nombre del producto --}}
        <div class="mb-4">
            <x-jet-label value="Nombre" class="w-full"/>
            <x-jet-input wire:model="product.name" type="text" class="w-full" placeholder="Ingrese el nombre del producto"/>
            <x-jet-input-error for="product.name"/>
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
                    wire:model="product.description"
                    x-data
                    x-init="ClassicEditor.create( $refs.miEditor)
                    .then(function(editor){
                        editor.model.document.on('change:data', () => {
                            @this.set('product.description', editor.getData())
                        })
                    })
                    .catch( error => {
                        console.error( error );
                    } );"
                    x-ref="miEditor">
                </textarea>
            </div>
            <x-jet-input-error for="product.description"/>
        </div>
    
        <div class="mb-4 grid grid-cols-2 gap-6">
            {{-- Brand --}}
            <div>
                <x-jet-label value="Marca" />
                <select wire:model="product.brand_id" class="form-control w-full">
                    <option value="" selected disabled hidden>Seleccione una marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="product.brand_id"/>
            </div>
            {{-- Price --}}
            <div>
                <x-jet-label value="Precio" />
                <x-jet-input wire:model="product.price" type="number" class="w-full" step="0.1"/>
                <x-jet-input-error for="product.price"/>
            </div>
        </div>
    
        <div>
            @if ($this->subcategory)    
                @if (!$this->subcategory->color && !$this->subcategory->size)
                    <x-jet-label value="Stock" />
                    <x-jet-input wire:model="product.quantity" type="number" class="w-full"/>
                    <x-jet-input-error for="product.quantity"/>
                @endif
            @endif
        </div>

        <div class="flex justify-end items-center mt-4">
            <x-jet-action-message class="mr-3" on="updated">
                Actualizado
            </x-jet-action-message>
            <x-jet-button  
                wire:click="save"
                wire:loading.attr="disable"
                wire:target="save"> 
                Actualizar producto 
            </x-jet-button>
        </div>
    </div>

    @if ($this->subcategory)
        @if ($this->subcategory->size)
            <livewire:admin.size-product :product="$product" :wire:key="'size-product-'.$product->id"/>
        @elseif($this->subcategory->color)
            <livewire:admin.color-product :product="$product" :wire:key="'color-product-'.$product->id"/>
        @endif
    @endif
    
    @push('script')
        <script>
            Dropzone.options.myAwesomeDropzone = {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dictDefaultMessage: "Arrastre una imagen al recuadro",
                acceptedFiles: 'image/*',
                paramName: "file",
                maxFilesize: 2,
                complete: function(file){
                    this.removeFile(file);
                },
                queuecomplete: function(){
                    Livewire.emit('refreshProduct');
                }
            };
        </script>
        <script>
            Livewire.on('deletePivot', pivot => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Esta acción es irrreversible ",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.color-product', 'delete', pivot);
                        Swal.fire(
                            'Eliminado',
                            'Tu producto ha sido eliminado.',
                            'success',
                        )
                    }
                })
            })
        </script>
        {{-- <script>
            Livewire.on('deleteColorSize', pivot => {
                // Swal.fire({
                //     title: 'Estas seguro?',
                //     text: "Esta acción es irrreversible ",
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Eliminar'
                //     }).then((result) => {
                //     if (result.isConfirmed) {
                //         Livewire.emitTo('admin.color-size', 'delete', pivot);
                //         Swal.fire(
                //             'Eliminado',
                //             'Tu producto ha sido eliminado.',
                //             'success',
                //         )
                //     }
                // })
                Livewire.emitTo('admin.color-size', 'delete', pivot);
            })
        </script> --}}
        <script>
            Livewire.on('deleteSize', sizeId => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Esta acción es irrreversible ",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.size-product', 'delete', sizeId);
                        Swal.fire(
                            'Eliminado',
                            'La talla ha sido eliminada.',
                            'success',
                        )
                    }
                })
            })
        </script>
    @endpush
</div>
