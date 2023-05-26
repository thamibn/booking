<script setup></script>

<template>
    <section class="h-screen bg-gray-300">
        <main class="flex-auto overflow-y-auto overflow-x-hidden p-8 bg-gray-300">
            <section class="rounded overflow-y-auto !bg-grey-800">
                <slot/>
            </section>
        </main>
    </section>
</template>
