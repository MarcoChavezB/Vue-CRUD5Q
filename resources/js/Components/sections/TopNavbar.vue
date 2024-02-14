<template>
    <nav>
        <div class="container mx-auto flex justify-between items-center py-4">
            <router-link to="/">
                <img src="/images/logo.svg" alt="Laravel" />
            </router-link>
            <div>
                <router-link to="/login" class="text-sm text-gray-700">Login</router-link>
                <router-link to="/register" class="ml-4 text-sm text-gray-700">Register</router-link>
            </div>
        </div>
    </nav>
    <main>
        <slot name="body"/>
    </main>
</template>