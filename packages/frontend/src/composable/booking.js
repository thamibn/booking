import {reactive, toRefs} from "vue";
import {HTTP} from "../utils/http";
import {pickBy} from "lodash";

const state = reactive({
    bookings: [],
    bookingsTotal: 0
})
export default function useBooking() {
    const getBookings = async (params) => {
        params = params || {};
        const results = await HTTP.get('bookings', {
            params: params,
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });
        state.bookings = results.data.bookings
        state.bookingsTotal = results.data.bookings.data.length
    }
    return {
        ...toRefs(state),
        getBookings
    }
}
