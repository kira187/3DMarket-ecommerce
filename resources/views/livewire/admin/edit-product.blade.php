<div class="pt-5">
    {{-- Informacion del producto --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">                    
                    <div id="header" class="d-flex flex-column flex-sm-row align-items-center mb-2">
                        <div class="container">
                            <h3 class="box-title">Información del producto</h3>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="form-group @error('product.name') has-danger @enderror">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" wire:model="product.name"
                                            class="form-control @error('product.name') form-control-danger @enderror" />
                                        @error('product.name')
                                            <small class="form-control-feedback" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('slug') has-danger @enderror">
                                        <label class="control-label">Slug</label>
                                        <input type="text" disabled class="form-control" wire:model="slug" @error('slug') form-control-danger @enderror"/>
                                        @error('slug')
                                        <small class="form-control-feedback" role="alert">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div wire:ignore>
                                            <label class="control-label">Descripción</label>
                                            <textarea class="form-control" rows="4" 
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
                                            x-ref="miEditor"> </textarea>
                                        </div>
                                        @error('product.description')
                                            <small class="form-control-feedback" role="alert" style="color:#fc4b6c;">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Categoria</label>
                                        <select name="categoria" class="form-control" wire:model="category_id">
                                            <option value="" hidden selected disabled>Elegir categoria</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                            
                                <div class="col md-6">
                                    <div class="form-group @error('product.subcategory_id') has-danger @enderror">
                                        <label class="control-label">Subcategoria</label>
                                        <select class="form-control" wire:model="product.subcategory_id">
                                            <option value="" hidden selected>Elegir Subcategoria</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product.subcategory_id')
                                            <small class="form-control-feedback" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('product.price') has-danger @enderror">
                                        <label class="control-label">Precio</label>
                                        <input type="number" step="0.1" class="form-control @error('product.price') form-control-danger @enderror" wire:model="product.price">
                                        @error('product.price')
                                        <small class="form-control-feedback" role="alert">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Marca</label>
                                        <select wire:model="product.brand_id" class="form-control">
                                            <option value="" selected disabled hidden>Seleccione una marca</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product.brand_id')
                                        <small class="form-control-feedback" role="alert">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($this->subcategory)    
                                @if (!$this->subcategory->color && !$this->subcategory->size)    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group @error('product.quantity') has-danger @enderror">
                                                <label class="control-label">Stock</label>
                                                <input type="number" class="form-control  @error('product.quantity') form-control-danger @enderror" wire:model="product.quantity">
                                                @error('product.quantity')
                                                    <small class="form-control-feedback" role="alert">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="form-actions text-right">
                                <x-jet-action-message class="mr-3" on="updated">
                                    Actualizado
                                </x-jet-action-message>
                                <button  class="btn btn-success"
                                    wire:click="save"
                                    wire:loading.attr="disable"
                                    wire:target="save"> 
                                    Actualizar producto 
                                </button>
                                <button type="reset" class="btn btn-danger ml-4"> Eliminar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   

    @if ($this->subcategory)
        @if ($this->subcategory->size)
            <livewire:admin.size-product :product="$product" :wire:key="'size-product-'.$product->id"/>
        @elseif($this->subcategory->color)
            <livewire:admin.color-product :product="$product" :wire:key="'color-product-'.$product->id"/>
        @endif
    @endif
    
     {{-- Imagenes --}}
     <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="header">
                        <div class="container">
                            <h3 class="box-title">Imagenes del producto</h3>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <div class="form-group" wire:ignore>
                                        <label class="control-label sr-only" for="imagen">Imagenes</label>
                                        <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone" id="my-awesome-dropzone"> </form>
                                    </div>
                                </div>                                    
                            </div>  
                            <div class="row no-gutters">
                                @if (count($product->images))
                                    @foreach ($product->images as $imagen)
                                        <div class="col-md-2"  wire:key="image-{{ $imagen->id }}">
                                            <img class="img-thumbnail" src="{{ Storage::url($imagen->url) }}" style="object-fit: cover;  width: 12rem; height: 9rem;">
                                            <div style="position:absolute; top:5%; right:5%">
                                                <button class="btn btn-danger btn-sm" wire:click="$emit('deleteImage', {{ $imagen->id }})"> x </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
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
