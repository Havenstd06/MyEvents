<template>
  <div class="flex flex-col justify-between h-full overflow-x-auto overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
    <div class="flex flex-col h-full overflow-y-auto">
      <div class="h-full grid grid-cols-12 gap-y-2">

        <div class="col-start-1 col-end-8 p-3 rounded-lg">
          <div class="flex flex-row items-center">
            <div class="flex flex-col items-center space-y-1 p-2 rounded-md">
              <img class="flex items-center justify-center h-8 w-auto rounded-md flex-shrink-0"
                   src="https://eu.ui-avatars.com/api/?name=Thomas"
              alt="Thomas" />

              <h3 class="font-medium text-sm">
                Thomas
              </h3>
            </div>

            <div class="relative text-sm py-2 px-4 shadow rounded-xl ml-1 bg-blueGray-900">
              <div>
                Hey How are you today?
              </div>
            </div>
          </div>
        </div>

        <div class="col-start-6 col-end-13 p-3 rounded-lg">
          <div class="flex items-center justify-start flex-row-reverse">
            <div class="flex flex-col items-center space-y-1 p-2 rounded-md">
              <img class="flex items-center justify-center h-8 w-auto rounded-md flex-shrink-0"
                   src="https://eu.ui-avatars.com/api/?name=Maxence"
                   alt="Maxence" />

              <h3 class="font-medium text-sm">
                Maxence
              </h3>
            </div>

            <div class="relative text-sm py-2 px-4 shadow rounded-xl mr-1 bg-blueGray-900">
              <div>
                Fine and you ?
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="h-14 flex items-end rounded-md bg-blueGray-900 w-full mt-1 py-2 px-1.5">
      <div class="flex flex-row items-center h-full w-full">
        <div class="flex-grow">
          <div class="relative w-full">
            <input type="text"
                   class="flex w-full border border-gray-900 rounded-md focus:outline-none focus:border-blueGray-500 focus:ring-0 bg-blueGray-800 h-10"
            />
          </div>
        </div>
        <div class="ml-2">
          <button class="flex items-center justify-center bg-blueGray-500 hover:bg-blueGray-600 rounded-md text-white px-4 py-1.5 flex-shrink-0">
            <span>Send</span>
            <span class="ml-2">
                  <svg class="w-4 h-4 transform rotate-45 -mt-px -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                </span>
          </button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
    name: "Chat"
}
</script>

<style scoped>
  .scrollbar-w-2::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
  }

  .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity));
  }

  .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
    --bg-opacity: 1;
    background-color: #edf2f7;
    background-color: rgba(237, 242, 247, var(--bg-opacity));
  }

  .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
    border-radius: 0.25rem;
  }
</style>
