<script setup>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import InputLabel from "@/components/InputLabel.vue";
import InputError from "@/components/InputError.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import {ref} from "vue";
import * as yup from "yup";
import {useField, useForm} from "vee-validate";
import {HTTP} from "../../utils/http";
import router from "../../router";

const BookingFormSchema = yup.object({
    date: yup.string().required().label("Date"),
    reason: yup.string().required().label("Reason"),
});

const {handleSubmit, errors: formErrors} = useForm({
    initialValues: {
        date: "",
        reason: "",
    },
    validationSchema: BookingFormSchema,
});
const {value: date} = useField('date');
const {value: reason} = useField('reason');
const isSubmitting = ref(false);

const onSubmit = handleSubmit(async (values, actions) => {
    isSubmitting.value = true;
    try {
        const results = await HTTP.post('bookings', values)
        isSubmitting.value = false;
        actions.resetForm();
        router.push({name: 'bookingList'});
    } catch (error) {
        isSubmitting.value = false;
        if (error.hasOwnProperty('response') && error.response.status === 422) {
            actions.setErrors(error.response.data.errors)
        }
    }
});


</script>
<template>
    <AuthenticatedLayout>
        <div class="space-y-4">
            <div class="p-4 text-gray-600 text-base font-semibold text-2xl bg-white rounded-lg">
                Create Booking
            </div>
            <div class="p-4 text-gray-600 bg-white rounded-lg">
                <form @submit.prevent="onSubmit" class="mt-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <InputLabel for="date" value="Date"/>
                            <el-date-picker
                                class="!w-full"
                                v-model="date"
                                type="date"
                                format="YYYY-MM-DD"
                                value-format="YYYY-MM-DD"
                                placeholder="Date"
                                clearable
                            />
                            <InputError class="mt-2" :message="formErrors.date"/>
                        </div>

                        <div>
                            <InputLabel for="reason" value="Reason"/>
                            <textarea v-model="reason" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-600 bg-gray-50 rounded-md border border-gray-300 focus:ring-primary focus:border-primary" placeholder="Write your reason here"></textarea>
                            <InputError class="mt-2" :message="formErrors.reason"/>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <div>
                            <a href="/"
                               class="flex items-center rounded text-white text-sm p-2 !bg-red-600 hover:shadow-lg focus:outline-none">
                                Back to Bookings
                            </a>
                        </div>
                        <div>
                            <PrimaryButton :disabled="isSubmitting">
                                Submit
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
