<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\AbonoController;
use App\Livewire\MarcaController;
use App\Livewire\InicioController;
use App\Livewire\AjusteInventarioController;
use App\Livewire\AsignacionRutaController;
use App\Livewire\DisenioController;
use App\Livewire\InventarioController;

use App\Livewire\MaterialController;
use App\Livewire\ProductoController;
use App\Livewire\TipoController;
use App\Livewire\ClienteController;
use App\Livewire\CombustibleController;
use App\Livewire\CompraController;
use App\Livewire\CotizacionController;
use App\Livewire\CreditoController;
use App\Livewire\CuentaCobrarController;
use App\Livewire\EnvioController;
use App\Livewire\EstadoCuentaController;
use App\Livewire\EstadoCuentaVentaController;
use App\Livewire\EstadoEnvioController;
use App\Livewire\HistorialCotizacionController;
use App\Livewire\InformeEstadoCuentaController;
use App\Livewire\InformeVentaController;
use App\Livewire\NotaCreditoController;
use App\Livewire\ProveedorController;
use App\Livewire\RoleController;
use App\Livewire\RutaController;
use App\Livewire\ServicioController;
use App\Livewire\SucursalController;
use App\Livewire\TrasladoController;
use App\Livewire\UsuarioController;
use App\Livewire\VehiculoController;
use App\Livewire\VentaController;
use App\Livewire\VentaRapidaController;
use App\Livewire\ViaticoController;
use App\Models\AjusteInventario;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

Route::view('/', 'welcome');


    Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware('auth')->group(function () {
       /* Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
       */

/*

        Route::get('marca', MarcaController::class)->middleware('can:marca')->name('marca');
        Route::get('tipo', TipoController::class)->middleware('can:tipo')->name('tipo');
        Route::get('material', MaterialController::class)->middleware('can:material')->name('material');
        Route::get('disenio', DisenioController::class)->middleware('can:disenio')->name('disenio');
        Route::get('producto', ProductoController::class)->middleware('can:producto')->name('producto');
        Route::get('inventario', InventarioController::class)->middleware('can:inventario')->name('inventario');
        Route::get('cliente', ClienteController::class)->middleware('can:cliente')->name('cliente');
        Route::get('proveedor', ProveedorController::class)->middleware('can:proveedor')->name('proveedor');
        Route::get('inicio', InicioController::class)->name('inicio');
        Route::get('compra', CompraController::class)->middleware('can:')->name('compra');
        Route::get('usuario', UsuarioController::class)->middleware('can:usuario')->name('usuario');
        Route::get('role',RoleController::class)->middleware('can:rol')->name('rol');
        Route::get('venta', VentaController::class)->middleware('can:venta')->name('venta');
        Route::get('estado_cuenta', EstadoCuentaController::class)->middleware('can:estado_cuenta')->name('estado_cuenta');
        Route::get('estado_cuenta_venta', EstadoCuentaVentaController::class)->middleware('can:estado_cuenta_venta')->name('estado_cuenta_venta');
        Route::get('ajuste_inventario', AjusteInventarioController::class)->middleware('can:ajuste_inventario')->name('ajuste_inventario');
        Route::get('vehiculo', VehiculoController::class)->middleware('can:vehiculo')->name('vehiculo');
        Route::get('envio', EnvioController::class)->middleware('can:envio')->name('envio');

        Route::get('credito', CreditoController::class)->middleware('can:credito')->name('credito');
        Route::get('cuenta_cobrar', CuentaCobrarController::class)->middleware('can:cuenta_cobrar')->name('cuenta_cobrar');
        Route::get('venta_rapida', VentaRapidaController::class)->middleware('can:venta_rapida')->name('venta_rapida');
        Route::get('asignacion_ruta', AsignacionRutaController::class)->middleware('can:asignacion_ruta')->name('asignacion_ruta');

        Route::get('ruta', RutaController::class)->middleware('can:ruta')->name('ruta');

        Route::get('estado_envio', EstadoEnvioController::class)->middleware('can:estado_envio')->name('estado_envio');
        Route::get('envio', EnvioController::class)->middleware('can:envio')->name('envio');

        Route::get('sucursal', SucursalController::class)->middleware('can:sucursal')->name('sucursal');
        Route::get('traslado', TrasladoController::class)->middleware('can:traslado')->name('traslado');

        Route::get('servicio', ServicioController::class)->middleware('can:servicio')->name('servicio');
        Route::get('abono', AbonoController::class)->middleware('can:abono')->name('abono');
        Route::get('nota_credito', NotaCreditoController::class)->middleware('can:nota_credito')->name('nota_credito');


        */
        //Route::get('generate-pdf', [PDFController::class, 'generatePDF']);




        Route::get('marca', MarcaController::class)->name('marca');
        Route::get('tipo', TipoController::class)->name('tipo');
        Route::get('material', MaterialController::class)->name('material');
        Route::get('disenio', DisenioController::class)->name('disenio');
        Route::get('producto', ProductoController::class)->name('producto');
        Route::get('inventario', InventarioController::class)->name('inventario');
        Route::get('cliente', ClienteController::class)->name('cliente');
        Route::get('proveedor', ProveedorController::class)->name('proveedor');
        Route::get('inicio', InicioController::class)->name('inicio');
        Route::get('compra', CompraController::class)->name('compra');
        Route::get('usuario', UsuarioController::class)->name('usuario');
        Route::get('role',RoleController::class)->name('rol');
        Route::get('venta', VentaController::class)->name('venta');
        Route::get('estado_cuenta', EstadoCuentaController::class)->name('estado_cuenta');
        Route::get('estado_cuenta_venta', EstadoCuentaVentaController::class)->name('estado_cuenta_venta');
        Route::get('ajuste_inventario', AjusteInventarioController::class)->name('ajuste_inventario');
        Route::get('vehiculo', VehiculoController::class)->name('vehiculo');
        Route::get('envio', EnvioController::class)->name('envio');

        Route::get('credito', CreditoController::class)->name('credito');
        Route::get('cuenta_cobrar', CuentaCobrarController::class)->name('cuenta_cobrar');
        Route::get('venta_rapida', VentaRapidaController::class)->name('venta_rapida');
        Route::get('asignacion_ruta', AsignacionRutaController::class)->name('asignacion_ruta');

        Route::get('ruta', RutaController::class)->name('ruta');

        Route::get('estado_envio', EstadoEnvioController::class)->name('estado_envio');
        Route::get('envio', EnvioController::class)->name('envio');

        Route::get('sucursal', SucursalController::class)->name('sucursal');
        Route::get('traslado', TrasladoController::class)->name('traslado');

        Route::get('servicio', ServicioController::class)->name('servicio');
        Route::get('abono', AbonoController::class)->name('abono');
        Route::get('nota_credito', NotaCreditoController::class)->name('nota_credito');
        Route::get('cotizacion', CotizacionController::class)->name('cotizacion');
        Route::get('historial_cotizacion', HistorialCotizacionController::class)->name('historial_cotizacion');


        Route::get('informe_venta', InformeVentaController::class)->name('informe_venta');
        Route::get('informe_estado_cuenta', InformeEstadoCuentaController::class)->name('informe_estado_cuenta');

        Route::get('combustible', CombustibleController::class)->name('combustible');
        Route::get('viatico', ViaticoController::class)->name('viatico');




    });


        Route::get('pdf-venta-rapida/{id?}}', [VentaRapidaController::class, 'pdfVentaRapida'])->name('pdfVentaRapida');
/*
        Route::get('pdf-exportar-abono/{id?}}', [AbonoController::class, 'pdfExportarAbono'])->name('pdfExportarAbono');
        Route::get('pdf-exportar-nota-credito/{id?}}', [NotaCreditoController::class, 'pdfExportarNotaCredito'])->name('pdfExportarNotaCredito');



        Route::get('pdf-exportar-estado-cuenta-venta}', [EstadoCuentaVentaController::class, 'pdfExportarEstadoCuentaVenta'])->name('pdfExportarEstadoCuentaVenta');
        Route::get('pdf-exportar-estado-cuenta-venta/{id?}', [EstadoCuentaVentaController::class, 'pdfExportarEstadoCuentaVenta'])->name('pdfExportarEstadoCuentaVenta');

        Route::get('pdf-exportar-ajuste-inventario/{id?}', [AjusteInventarioController::class, 'pdfExportarAjusteInventario'])->name('pdfExportarAjusteInventario');

        Route::get('pdf-exportar-traslado/{id?}', [TrasladoController::class, 'pdfExportarTraslado'])->name('pdfExportarTraslado');

        Route::get('pdf-exportar-compra/{id?}', [CompraController::class, 'pdfExportarCompra'])->name('pdfExportarCompra');

        Route::get('pdf-exportar-credito/{id?}', [CreditoController::class, 'pdfExportarCredito'])->name('pdfExportarCredito');


        Route::get('pdf-exportar-cotizacion/{id?}', [HistorialCotizacionController::class, 'pdfExportarCotizacion'])->name('pdfExportarCotizacion');

        Route::get('pdf-exportar-ruta/{id?}', [RutaController::class, 'pdfExportarRuta'])->name('pdfExportarRuta');

        Route::get('pdf-exportar-envio/{id?}', [EnvioController::class, 'pdfExportarEnvio'])->name('pdfExportarEnvio');
        Route::get('pdf-exportar-inventario}', [InventarioController::class, 'pdfExportarInventario'])->name('pdfExportarInventario');


        Route::get('pdf-exportar-estado-cuenta/{id}', [EstadoCuentaController::class, 'pdfExportarEstadoCuenta'])->name('pdfExportarEstadoCuenta');

*/
require __DIR__.'/auth.php';
