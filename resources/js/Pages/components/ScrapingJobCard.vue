<template>
	<div class="flex flex-col bg-gray-200 rounded-lg p-4 m-2 w-96 border-2 border-opacity-0 hover:border-opacity-100 hover:border-indigo-800 hover:cursor-pointer" @click="goToDetail">
		<div class="flex flex-col items-start mt-4 gap-3">
			<h4 class="text-2xl font-semibold underline"><a :href="route('scrapingjob.detail', scrapingJob.id)">{{scrapingJob.search_keyword}}</a></h4>
			<p class=""><span class="font-bold">Created:</span> {{formatDate(scrapingJob.created_at)}}</p>
			<p class=""><span class="font-bold">Status:</span> {{scrapingJob.successfull == 1? "Completed": "In Progress"}}</p>
			<p class=""><span class="font-bold">Finished:</span> {{scrapingJob.finished_at? formatDate(scrapingJob.finished_at) : 'No'}}</p>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		scrapingJob: Object,
	},

	data () {
		return {
			finished: false,
		}
	},
	methods: {
		formatDate (raw) {
			if (!raw) {
				return;
			}
			let d = new Date(raw);
			return d.toLocaleString();
		},

		goToDetail () {
			this.$inertia.get(this.route("scrapingjob.detail", this.scrapingJob.id))
		}
	}

}
</script>

<style>
</style>