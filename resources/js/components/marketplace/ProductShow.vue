<template>
  <div class="product-page">
    <div class="container py-5">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/">Home</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/marketplace">Marketplace</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link :to="`/category/${product.category_slug}`">{{ product.category_name }}</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">{{ product.name }}</li>
        </ol>
      </nav>

      <div v-if="loading" class="row">
        <div class="col-lg-6">
          <div class="placeholder-glow">
            <div class="placeholder" style="height: 400px; background: #f8f9fa;"></div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="placeholder-glow">
            <div class="placeholder col-8 mb-3" style="height: 30px;"></div>
            <div class="placeholder col-6 mb-2" style="height: 20px;"></div>
            <div class="placeholder col-4 mb-4" style="height: 20px;"></div>
            <div class="placeholder col-12 mb-3" style="height: 100px;"></div>
          </div>
        </div>
      </div>

      <div v-else class="row">
        <!-- Product Images -->
        <div class="col-lg-6">
          <ProductGallery :images="product.images" :name="product.name" />
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
          <div class="product-info">
            <!-- Store Info -->
            <div class="store-info mb-3">
              <router-link 
                :to="`/store/${product.store_slug}`" 
                class="text-decoration-none"
              >
                <div class="d-flex align-items-center">
                  <img 
                    :src="product.store_logo || '/images/store-placeholder.png'" 
                    :alt="product.store_name"
                    class="store-logo me-2"
                    style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;"
                  >
                  <span class="store-name text-muted">{{ product.store_name }}</span>
                </div>
              </router-link>
            </div>

            <!-- Product Title -->
            <h1 class="product-title mb-3">{{ product.name }}</h1>

            <!-- Rating -->
            <div class="rating-section mb-3">
              <div class="d-flex align-items-center">
                <div class="rating me-2">
                  <i 
                    v-for="star in 5" 
                    :key="star" 
                    class="bi" 
                    :class="star <= Math.round(product.rating) ? 'bi-star-fill text-warning' : 'bi-star text-muted'"
                  ></i>
                </div>
                <span class="rating-value me-2">{{ product.rating.toFixed(1) }}</span>
                <span class="review-count text-muted">({{ product.review_count }} reviews)</span>
                <span class="mx-2 text-muted">•</span>
                <span class="sold-count text-muted">{{ product.sales_count }} vendidos</span>
              </div>
            </div>

            <!-- Pricing -->
            <div class="pricing-section mb-4">
              <div class="current-price h2 text-primary mb-1">
                {{ formatCurrency(product.current_price) }}
              </div>
              <div v-if="product.original_price > product.current_price" class="original-price">
                <span class="text-muted text-decoration-line-through me-2">
                  {{ formatCurrency(product.original_price) }}
                </span>
                <span class="discount-percentage text-danger fw-bold">
                  -{{