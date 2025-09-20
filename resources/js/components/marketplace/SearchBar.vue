<template>
    <div class="search-bar">
        <form @submit.prevent="handleSearch">
            <div class="input-group">
                <input
                    v-model="searchQuery"
                    type="text"
                    class="form-control"
                    placeholder="Pesquisar produtos..."
                    aria-label="Pesquisar produtos"
                >
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'SearchBar',
    setup() {
        const searchQuery = ref('');
        const router = useRouter();

        const handleSearch = () => {
            if (searchQuery.value.trim()) {
                router.push({
                    name: 'search',
                    query: { q: searchQuery.value.trim() }
                });
                searchQuery.value = '';
            }
        };

        return {
            searchQuery,
            handleSearch,
        };
    },
};
</script>

<style lang="scss" scoped>
.search-bar {
    .input-group {
        max-width: 400px;
    }

    .form-control {
        border-right: 0;
        
        &:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
    }

    .btn {
        border-left: 0;
    }
}
</style>