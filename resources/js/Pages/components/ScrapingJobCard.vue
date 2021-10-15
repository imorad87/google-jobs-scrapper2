<template>
	<div class="flex flex-col bg-gray-200 rounded-lg p-4 m-2 w-96">
		<div class="flex flex-col items-start mt-4 gap-3">
			<h4 class="text-xl font-semibold"><a :href="route('scrapingjob.detail', scrapingJob.id)">{{scrapingJob.search_keyword}}</a></h4>
			<p class="text-sm">Created At: {{scrapingJob.created_at}}</p>
			<p class="text-sm">Finished: {{scrapingJob.finished}}</p>
			<p class="text-sm">Status: {{scrapingJob.successfull}}</p>
			<p class="text-sm">Finished At: {{scrapingJob.updated_at}}</p>
			<p class="text-sm"><a :href="scrapingJob.scraping_url" target="_blank">Google Jobs Link</a></p>
			<a class="p-2 leading-none rounded font-medium mt-3 bg-gray-400 text-xs uppercase" :href="route('scrapingjob.detail', scrapingJob.id)">Job Detail</a>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		scrapingJob: Object,
	}

}
</script>

<style>
</style>