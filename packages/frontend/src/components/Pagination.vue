<script setup>
import useBooking from "../composable/booking";
import {HTTP} from "../utils/http";

const props = defineProps({
    from: Number,
    to: Number,
    total: Number,
    current_page: Number,
    last_page: Number,
    first_page_url: String,
    prev_page_url: String,
    next_page_url: String,
    last_page_url: String,
})

const {bookings, bookingsTotal} = useBooking();

const paginate = async (url)=>{
    const results = await HTTP.get(url);
    bookings.value = results.data.bookings
    bookingsTotal.value = results.data.total
}

</script>
<template>
    <div class="flex items-center justify-between">
        <div>
            <span v-if="props.total > 0">
                Showing {{ props.from }} - {{ props.to }} of {{ props.total }} results
            </span>
            <span v-else>
                Showing 0 results
            </span>
        </div>
        <div class="flex items-center justify-end space-x-2 text-right mr-2.5">
            <a @click="paginate(prev_page_url)" href="#" title="First page"
                  class="rounded text-white text-sm p-1 bg-gray-900 hover:bg-gray-900 hover:shadow-lg focus:outline-none"
               :class="{'!pointer-events-none !bg-gray-300' : !prev_page_url}"
            >
                <icon-ic-round-keyboard-double-arrow-left />
            </a>
            <a @click="paginate(prev_page_url)" href="#" title="Previous page"
                  class="rounded text-white text-sm p-1 bg-gray-900 hover:bg-gray-900 hover:shadow-lg focus:outline-none"
               :class="{'!pointer-events-none !bg-gray-300' : !prev_page_url}"
            >
                <icon-ic-round-chevron-left />
            </a>
            <a @click="paginate(next_page_url)" href="#" title="Next page"
                  class="text-white text-sm p-1 bg-gray-900 hover:bg-gray-900 hover:shadow-lg focus:outline-none"
               :class="{'!pointer-events-none !bg-gray-300' : !next_page_url}"
            >
                <icon-ic-round-chevron-right />
            </a>
            <a @click="paginate(last_page_url)" href="#" title="Last page"
                  class="text-white text-sm p-1 bg-gray-900 hover:bg-gray-900 hover:shadow-lg focus:outline-none"
               :class="{'!pointer-events-none !bg-gray-300' : current_page == last_page}"
            >
                <icon-ic-round-keyboard-double-arrow-right />
            </a>
        </div>
    </div>
</template>
