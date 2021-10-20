<template>
	<div class="w-8/12 m-auto flex flex-col mt-52">
		<div class="fixed top-0 right-0 px-6 py-4 sm:block flex gap-5">
			<a :href="route('scrapingjobs.index')" class="text-lg text-gray-700 underline">
				Home
			</a>

		</div>
		<p class="text-4xl text-center">Scraping Job Detail For <span class="font-semibold">{{scrapingJob.search_keyword}}</span></p>

		<div class="job-information flex gap-3 justify-center items-center mt-10 justify-between">
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Title</span>
				<p class="text-xl">{{scrapingJob.search_keyword}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Created</span>
				<p class="text-md">{{formatDate(scrapingJob.created_at)}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Updated</span>
				<p class="text-md">{{formatDate(scrapingJob.updated_at)}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Status</span>
				<p class="text-xl">{{scrapingJob.successfull == 1? "Completed": "In Progress"}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Completed</span>
				<p class="text-xl">{{scrapingJob.finished == 1? "Yes": "No"}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Scraped Jobs</span>
				<p class="text-xl">{{scrapingJob.google_jobs.length}}</p>
			</div>
			<div class="rounded-xl border-2 border-indigo-800 p-3 flex flex-col gap-2 items-center jutsify-center w-2/12">
				<span class="text-2xl font-extrabold">Google Link</span>
				<p class="text-xl underline"><a :href="scrapingJob.scraping_url" target="_blank">Go to Google</a></p>
			</div>
		</div>
		<div class="controls flex justify-between">
			<!-- <input type="button" value="Export to CSV" @click="exportCsv"> -->
			<a class="font-bold mt-10 mb-10 hover:bg-indigo-800 hover:text-white bg-white text-indigo-800 p-2 rounded-xl underline" :href="route('scrapingjobs.index')">Back</a>
			<div class="flex gap-6">
				<a class="font-extrabold mt-10 mb-10 border-3 border-red-900 border-opacity-0 hover:border-opacity-100 bg-red-700 text-white p-2 rounded-xl underline" href="#" @click="deleteJob">DELETE</a>
				<a class="font-bold mt-10 mb-10 hover:bg-indigo-800 hover:text-white bg-white text-indigo-800 p-2 rounded-xl underline" :href="route('export.csv', scrapingJob.id)">Export to CSV</a>
			</div>
		</div>
		<p class="text-3xl mb-5 font-extrabold underline ml-2">Scraped Google Jobs</p>
		<div class="grid grid-cols-4" v-if="scrapingJob.google_jobs">
			<GoogleJobCard v-for="googleJob in scrapingJob.google_jobs" :googleJob="googleJob" :key="googleJob.id" />
		</div>

	</div>
</template>

<script>
import Link from '@/Jetstream/ResponsiveNavLink.vue';
import { Head } from "@inertiajs/inertia-vue3"
import GoogleJobCard from "@/Pages/components/GoogleJobsCard.vue";
export default {
	components: {
		Link,
		Head,
		GoogleJobCard

	},
	props: {
		scrapingJob: Object,
	},

	methods: {
		exportCsv () {
			this.$inertia.get(this.route("export.csv", this.scrapingJob.id));
		},

		formatDate (raw) {
			let d = new Date(raw);
			return d.toLocaleString();
		},
		deleteJob () {
			this.$inertia.delete(this.route("scrapingjob.delete", this.scrapingJob.id));
		}
	}

}
</script>

<style>
</style>