<template>
<div>
        <NavLight/>
           <section class="relative md:h-screen md:py-0 py-36 items-center overflow-hidden bg-gradient-to-t to-teal-600 via-teal-600/50 from-transparent" id="home">
            <div class="container relative">
                <div class="grid grid-cols-1 md:mt-48 mt-10 text-center">
                    <h4 class="font-bold lg:leading-normal leading-normal tracking-wide text-4xl lg:text-5xl capitalize text-white mb-1">Build Faster &  Secure <br> Short Links </h4>
                    <!-- <p class="text-white/70 text-lg max-w-xl mx-auto">Take your business to the next level</p> -->

                  <Transition>
                    <div class="subcribe-form mt-6 mb-3" v-if="show_form">
                        <div class="relative max-w-xl mx-auto " >
                            <input type="url" id="url" name="url" class="py-4 pe-5 ps-6 w-full h-[50px] outline-none text-black dark:text-white rounded-full bg-white/60 dark:bg-slate-900/60 shadow dark:shadow-gray-800" placeholder="Type URL:">
                            <div class="text-left pl-3" v-if="err_msg">
                              <small>Please input valied URL !! </small>
                            </div>
                            <div class="pt-5">
                                <button  @click="greet" id="elementToAddClass" class="hover:bg-teal-600 px-6 tracking-wide inline-flex items-center justify-center font-medium  top-[2px] end-[3px] h-[46px] bg-teal-500 text-white rounded-full">
                                  <span v-if="loader" class="loader"></span>
                                  <span v-if="txt_short" class="short">Shorten</span>
                                  </button>
                            </div>
                        </div><!--end form-->
                    </div>
                  </Transition>





                  <Transition>
                    <div class="subcribe-form mt-6 mb-3" v-if="show_result">

<div class="container relative">


                <div  class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden border border-[#14b8a6] h-fit" >
                    <div class="content mt-6 relative z-1">
                      <div class="subcribe-form mt-6 mb-3">
                        <div class="relative max-w-xl mx-auto">
                            <input type="url" id="shorturl" name="short_url" class="py-4 pe-5 ps-6 w-full h-[50px] outline-none text-black dark:text-white rounded-full bg-white/60 dark:bg-slate-900/60 shadow dark:shadow-gray-800" ref="inputField" v-model="inputValue">
                            <button @click="copyToClipboard" class="px-6 tracking-wide inline-flex items-center justify-center font-medium absolute top-[2px] end-[3px] h-[46px] bg-teal-500 text-white rounded-full"> <span class="mdi mdi-content-copy"></span> </button>
                        </div><!--end form-->
                    </div>

                        <div class="mt-6">
                            <a @click="again" class="text-teal-500">Try Again <i class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div>
        </div><!--end container-->

                    </div>
                  </Transition>


                    <!-- <div class="overflow-hidden mt-8">
                        <img src="../assets/images/home.png" alt="">
                    </div> -->
                </div><!--end grid-->
            </div><!--end container-->
        </section>

</div>


</template>

<script>

// import NavLight from '@/components/NavLight.vue'
// import About from '@/components/About.vue'
// import Features from '@/components/Features.vue'
// import AgencyTab from '@/components/AgencyTab.vue'
// import Cta from '@/components/Cta.vue'
// import Client from '@/components/Client.vue'
// import Pricing from '@/components/Pricing.vue'
// import Blogs from '@/components/Blogs.vue'
// import GetInTouch from '@/components/GetInTouch.vue'
import axios from 'axios';

 import { Swiper, SwiperSlide } from 'swiper/vue';
  import { Navigation , Autoplay} from 'swiper/modules';

  // Import Swiper styles
  import 'swiper/css';

function isValidURL(url) {
  // Regular expression for URL validation
  const urlPattern = /^(ftp|http|https):\/\/[^ "]+$/;

  // Test the URL against the regular expression
  return urlPattern.test(url);
}

export default {
        components:{
         Swiper,
      SwiperSlide,
        },
        data() {
    return {
      err_msg: false,
      loader: false,
      txt_short: true,
      show_form: true,
      show_result: false,
      short_url: ''
    };
  },
  mounted() {
  console.log(import.meta.env.VITE_API_PUBLIC_KEY)
},
  methods: {
    async greet() {
      let url = document.getElementById('url').value;

      if (!isValidURL(url)){
        this.err_msg = true
        return false
      }

      this.err_msg = false
      let element  = document.getElementById('elementToAddClass')
      element.setAttribute("disabled", "");
      element.classList.remove('bg-teal-500');
      element.classList.add('bg-teal-600');
      this.loader = true;
      this.txt_short = false;

try {
        // Define the data you want to send in the request body
        const data = {
          url: url
        };

    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    }

        // Send a POST request
        const response = await axios.post(import.meta.env.VITE_API_PUBLIC_KEY+'/api/create_short', data, {
            headers: headers
        });

        // Handle the response
        // console.log('Response:', response);


        if (response.status == 200){
          // Todo : append the response.data.uri_token
          console.log(response.data.uri_token)
          this.show_form = false
          this.show_result = true

          this.testt(response.data.uri_token)




        }


      } catch (error) {
        // Handle errors
        console.error('Error:', error);
      }

      // You can perform any other actions you need here
    },
    again(){
      this.show_result = false
      this.show_form = true

      // let element  = document.getElementById('elementToAddClass')
      // element.removeAttribute("disabled", "");
      // element.classList.add('bg-teal-500');
      // element.classList.remove('bg-teal-600');
      this.loader = false;
      this.txt_short = true;

    },
    testt(url){
      this.inputValue = import.meta.env.VITE_API_PUBLIC_KEY+'/s/'+url;
    },
    copyToClipboard() {
      // Select the input field
      this.$refs.inputField.select();
      // Execute the copy command
      document.execCommand('copy');
      // Deselect the input field
      this.$refs.inputField.setSelectionRange(0, 0);
    }
  }

};
</script>
<style scoped>
.swiper {
  width: 100%;
  height: 100%;
}

.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;

  /* Center slide text vertically */
  display: flex;
  justify-content: center;
  align-items: center;
}

.swiper-slide img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.loader {
    width: 20px;
    height: 20px;
    border: 3px solid #FFF;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    }

.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
