<template>
    <guest-layout>
        <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-lg">
            <section class="text-center">
                <h3 class="font-bold text-2xl">Welcome Test</h3>
                <p class="text-gray-600 pt-1">Sign in to your account</p>
                <div class="mx-auto mt-2 mb-6 w-24 border-b-2"/>
            </section>
            <section class="mt-10">
                <form class="flex flex-col" @submit="onSubmit">
                    <div>
                        <el-input clearable type="email" placeholder="Email" autocomplete="username"
                                  class="mb-2 w-full block" v-model="email"
                                  autofocus/>
                        <span class="text-red-600">{{ formErrors.email }}</span>
                    </div>
                    <div class="mt-4">
                        <el-input clearable show-password type="password" placeholder="Password"
                                  autocomplete="current-password"
                                  class="mb-2 w-full block" v-model="password"/>
                        <span class="text-red-600">{{ formErrors.password }}</span>
                    </div>
                    <div class="mt-4 flex flex-col md:flex-row md:justify-between md:items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" v-model="remember"
                                   class="rounded-sm border-primary focus:ring-0 focus:ring-offset-0 h-4 w-4 text-primary">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <label class="flex items-center mt-3 md:mt-0">
                            <a href="#"
                               class="underline text-sm text-gray-600 hover:text-primary">
                                Forgot your password?
                            </a>
                        </label>
                    </div>
                    <PrimaryButton class="mt-6" :disabled="isSubmitting" :isLoading="isSubmitting">
                        Sign In
                    </PrimaryButton>
                </form>
            </section>
        </main>
    </guest-layout>
</template>

<script setup>
import {onMounted, ref} from "vue";
import {useField, useForm} from "vee-validate";
import * as yup from "yup";
import GuestLayout from "../../layouts/Guest.vue";
import PrimaryButton from "../../components/PrimaryButton.vue";
import {HTTP} from "../../utils/http";
import router from "../../router";

const LoginFormSchema = yup.object({
    email: yup.string().required().email().label("Email"),
    password: yup.string().required().label("Password"),
});

const {handleSubmit, errors: formErrors} = useForm({
    initialValues: {
        email: "",
        password: "",
        remember: false,
    },
    validationSchema: LoginFormSchema,
});
const {value: email} = useField('email');
const {value: password} = useField('password');
const {value: remember} = useField('remember');
const isSubmitting = ref(false);

const onSubmit = handleSubmit(async (values, actions) => {
    isSubmitting.value = true;
    try {
        const results = await HTTP.post('login', values)
        isSubmitting.value = false;
        router.push({name: 'home'})

    } catch (error) {
        isSubmitting.value = false;
        if (error.hasOwnProperty('response') && error.response.status === 422) {
            actions.setErrors(error.response.data.errors)
        }
    }
});

</script>

