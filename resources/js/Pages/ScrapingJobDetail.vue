<template>
	<div class="w-5/12 m-auto flex flex-col mt-52">
		<div class="fixed top-0 right-0 px-6 py-4 sm:block flex gap-5">
			<Link :href="route('dashboard')" class="text-sm text-gray-700 underline">
			Dashboard
			</Link>

			<Link :href="route('login')" class="text-sm text-gray-700 underline">
			Log in
			</Link>

			<Link :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
			Register
			</Link>

		</div>
		<p class="text-2xl">Scraping Job Detail</p>

		{{scrapingJob.google_jobs[0].company_logo}}

	</div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
	components: {
		Link,
		Head
	},
	props: {
		scrapingJob: Object,
	}

}
</script>

<style>
</style>