<script setup>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import Pagination from "@/components/Pagination.vue";
import {onBeforeMount, ref, watch} from "vue";
import {debounce} from "lodash";
import useBooking from "../../composable/booking";
import {HTTP} from "../../utils/http";
import router from "../../router";
import {ElMessageBox} from "element-plus";
import {useRoute, useRouter} from "vue-router";

const params = ref({
    date: '',
    from_date: '',
    to_date: '',
    resultsPerPage: 10,
    sort: '-date',
    page: 1,
    ...useRoute().query,
})

const resetAllFilters = () => {
    params.value.date = ''
    params.value.to_date = ''
    params.value.resultsPerPage = 10
    params.value.sort = '-date'
}

watch(params.value, debounce(async () => {

    let qParams = {
        'filter[date]' : params.value.date,
        'filter[from_date]' : params.value.from_date,
        'filter[to_date]' : params.value.to_date,
        'resultsPerPage' : params.value.resultsPerPage,
        'sort' : params.value.sort,
    }
    await getBookings(qParams);
    // useRouter().push({ query: params.value })
}, 500), {
    deep: true,
    immediate: true
})

const sortTable = (field) => {
    params.value.sort = field === params.value.sort ? '-' + field : field;
}

const {bookings, bookingsTotal, getBookings} = useBooking();
onBeforeMount(async () => {
    // await getBookings();
    console.log(bookings.value);
})

const loggingOut = ref(false)
const logout = () => {
    ElMessageBox.confirm(
        'Are you sure you want to log in?',
        'Warning',
        {
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    ).then(async () => {
        loggingOut.value = true;
        try {
            const results = await HTTP.post('logout', {})

            if(results.status === 200){
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.setItem('authenticated', false);
                loggingOut.value = false;
                router.push({name: 'login'})
            }
        } catch (error) {
            loggingOut.value = false;
        }
    })
}

</script>
<template>
    <AuthenticatedLayout>
        <div class="space-y-6">
            <h1 class="text-base font-bold text-2xl">
                Bookings
            </h1>

            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                <div class="flex items-center justify-start space-x-2">
                    <el-input
                        class="!w-[10rem]"
                        v-model="params.date"
                        clearable
                        placeholder="Date"
                    >
                    </el-input>
                    <el-date-picker
                        class="!w-[10rem]"
                        v-model="params.from_date"
                        type="date"
                        format="YYYY-MM-DD"
                        value-format="YYYY-MM-DD"
                        placeholder="Date From"
                        clearable
                    />
                    <el-date-picker
                        class="!w-[10rem]"
                        v-model="params.to_date"
                        type="date"
                        format="YYYY-MM-DD"
                        value-format="YYYY-MM-DD"
                        placeholder="Date To"
                        clearable
                    />
                    <el-select v-model="params.resultsPerPage" filterable class="!w-[4rem]">
                        <el-option
                            v-for="page in [10, 15, 20, 25, 50]"
                            :key="page"
                            :label="page"
                            :value="page"
                        />
                    </el-select>
                    <a href="#" @click="resetAllFilters" class="text-teal-600 underline">reset filters</a>
                </div>
                <div class="flex items-center justify-start space-x-2">
                    <a href="/bookings/create"
                       class="flex items-center rounded text-white text-sm p-1 bg-primary hover:bg-gray-900 hover:shadow-lg focus:outline-none">
                        Create Booking
                    </a>
                    <a @click="logout"
                       class="flex cursor-pointer justify-center items-center rounded text-white text-sm p-1 bg-red-600 hover:bg-gray-900 hover:shadow-lg focus:outline-none">
                        Logout
                        <div v-if="loggingOut" class="btn-spinner ml-4"></div>
                    </a>
                </div>
            </div>

            <div class="p-4 text-gray-600 bg-white rounded-lg overflow-auto">
                <table class="w-full">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-2 text-sm font-semibold text-left tracking-wide cursor-pointer"
                            @click="sortTable('date')">
                            <div class="flex">
                                Date
                                <icon-ic-baseline-keyboard-arrow-down v-if="params.sort === 'date'"/>
                                <icon-ic-baseline-keyboard-arrow-up v-if="params.sort === '-date'"/>
                            </div>
                        </th>
                        <th class="p-2 text-sm font-semibold text-left tracking-wide cursor-pointer"
                            @click="sortTable('reason')">
                            <div class="flex">
                                Reason
                                <icon-ic-baseline-keyboard-arrow-down v-if="params.sort === 'reason'"/>
                                <icon-ic-baseline-keyboard-arrow-up v-if="params.sort === '-reason'"/>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    <tr v-for="(booking, index) in bookings.data" :key="booking.tinyMce">
                        <td class="p-2 text-sm text-gray-600">{{ booking.date }}</td>
                        <td class="p-2 text-sm text-gray-600">{{ booking.reason.substring(0, 50) + "..." }}</td>
                    </tr>
                    <tr v-if="bookingsTotal == 0">
                        <td class="px-2 py-2 whitespace-normal text-primary border-b border-gray-200 text-center"
                            colspan="6">
                            <span class="flex flex-row justify-center">0 results found</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="py-2 px-4 text-gray-600 bg-white rounded-lg overflow-auto">
                <Pagination v-if="bookingsTotal != 0"
                            :from="bookings.meta.from"
                            :to="bookings.meta.to"
                            :total="bookings.meta.total"
                            :current_page=bookings.meta.current_page
                            :last_page=bookings.meta.last_page
                            :next_page_url=bookings.meta.next_page_url
                            :prev_page_url=bookings.meta.prev_page_url
                            :first_page_url=bookings.meta.first_page_url
                            :last_page_url=bookings.meta.last_page_url
                />
            </div>
        </div>
    </AuthenticatedLayout>

</template>
