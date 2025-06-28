<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('canteen_products', function (Blueprint $table) {
            $table->id();

            // Relasi dasar
            $table->foreignId('canteen_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('canteen_product_categories')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('canteen_suppliers')->nullOnDelete();
            $table->foreignId('parent_product_id')->nullable()->constrained('canteen_products')->nullOnDelete();

            // Identitas produk
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('external_code')->nullable();
            $table->text('description')->nullable();

            // Harga dan stok
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('tax_percent', 5, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('reorder_point')->default(0);
            $table->boolean('stock_alert')->default(false);
            $table->boolean('stock_tracking')->default(true);

            // Info produk tambahan
            $table->string('unit')->default('pcs');
            $table->string('status_label')->nullable();
            $table->integer('min_order_qty')->nullable();
            $table->integer('max_order_qty')->nullable();
            $table->integer('sales_limit_daily')->nullable();
            $table->integer('weight_grams')->nullable();
            $table->string('stock_location')->nullable();
            $table->dateTime('expired_at')->nullable();

            // Kontrol dan metadata lanjutan
            $table->json('composition')->nullable();       // bahan / paket isi
            $table->json('tags')->nullable();              // fleksibel, bebas isi
            $table->json('labels')->nullable();            // untuk frontend UI
            $table->json('available_days')->nullable();    // ["Senin", "Selasa"]
            $table->time('orderable_until')->nullable();   // jam batas beli

            $table->string('purchase_frequency')->nullable(); // 'daily', 'weekly'
            $table->string('visibility')->default('public');  // public, staff_only, hidden
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_serialized')->default(false);
            $table->boolean('is_active')->default(true);

            // Media
            $table->string('photo_path')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteen_products');
    }
};
