<template>
    <div class="container d-flex justify-content-end">
        <button type="button" class="btn btn-dark mt-2" @click="logout">Logout</button>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div v-for="item,index in form" :key="item">
                    <h3>Item {{index + 1 }}</h3>
                    <div class="row">
                        <div class="col-sm-5">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" v-model="item.name">
                        </div>
                        <div class="col-sm-5">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" v-model="item.price">
                        </div>
                        <div class="col-sm-2 pt-4">
                            <button type="button" class="btn btn-danger" @click="removeRow(index)">X</button>&nbsp;
                            <button type="button" class="btn btn-success" @click="addRow">+</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success mt-3" @click="saveItem">Save</button>
            </div>
        </div>
    </div>

</template>
<script>
import { reactive } from 'vue';
import { useRouter } from 'vue-router'
import { useStore } from 'vuex';
import axios from 'axios';

export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        const form = reactive([
            { name: '', price: '' }
        ])
        const addRow = () => {
            form.push({ name: '', price: '' })
        }
        const removeRow = (index) => {
            if (form.length > 1) {
                form.splice(index, 1)
            }
        }
        const saveItem = () => {
            axios.post('/api/item', form).then(res => {
                if (res.data.success) {
                    window.location.reload(true);
                    // router.push({ name: 'Home' })
                }
            }).catch(e => {
                errors.value = e.response.data.message
            })
        }
        function logout() {
            store.dispatch('removeToken');
            router.push({ name: 'Home' })
        }
        return {
            form,
            addRow,
            logout,
            removeRow,
            saveItem
        }
    },
}
</script>
