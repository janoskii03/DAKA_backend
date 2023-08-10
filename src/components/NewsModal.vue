<template>
    <div class="news_modal_container">
        <div class="news_modal_backdrop"></div>

        <form action="" class="news_modal" id="news_modal">
            <div class="news_edit">
                <div class="news_header mb-3">
                    <h5 class="modal-title" id="">
                        {{ title }}
                        <button type="button" @click="toggleReadOnly" :class='{ button_none: title === "新增消息" }'>
                            編輯
                        </button>
                    </h5>

                    <span>管理者：中壢分店</span>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="news_body">
                    <!-- 標題 -->
                    <div class="row mb-3">
                        <label for="news_title" class="col-1 col-form-label">標題</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="news_title" maxlength="20" placeholder="限制字數 20 字"
                                :disabled="isReadOnly" v-model="news.news_title">
                        </div>

                    </div>
                    <!-- 日期和類別 -->

                    <div class="row mb-3">
                        <label for="news_date" class="col-1 col-form-label">日期</label>
                        <div class="col-5">
                            <input type="date" class="form-control" id="news_date" :disabled="isReadOnly"
                                v-model="news.news_date">
                        </div>

                        <label for="news_category" class="col-1 col-form-label">類別</label>
                        <div class="col-5">
                            <select class="col-12 form-select form-control" id="news_category" :disabled="isReadOnly"
                                v-model="news.news_category">
                                <option :selected="news.news_category === 'NEWS'">NEWS</option>
                                <option :selected="news.news_category === 'ACTIVITY'">ACTIVITY</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- 上傳圖片 -->
                        <label for="" class="col-1 col-form-label">圖檔</label>
                        <div class="col-5">
                            <input
                            type="file"
                            class="form-control col-10"
                            required
                            accept=".jpg, .png"
                            :disabled="isReadOnly"
                            @change="previewObjectURL"
                            >
                            <div class="img_block mt-3 col-10">
                                <img :src="news.news_pic" alt="" >
                            </div>

                        </div>

                        <!-- 內文 -->
                        <label for="news_content" class="form-label col-1">內文</label>
                        <div class="col-5">
                            <textarea class="form-control" id="news_content" rows="10" v-model="news.news_text"
                                @input="countWords" placeholder="限制字數1000字" maxlength="1000" :disabled="isReadOnly">
                        </textarea>
                            <p class="wordCount mt-3">{{ wordCount }} / 1000</p>
                        </div>

                    </div>
                </div>
                <div class="news_footer mt-3">
                    <button type="button" class="btn btn-secondary m-1" :disabled="isReadOnly"
                        @click="closeModal">儲存草稿</button>
                    <button type="button" class="btn btn-primary m-1" :disabled="isReadOnly"
                        @click="closeModal">發佈送出</button>
                </div>
            </div>
        </form>
    </div>
</template>


<script>
import { Form } from 'view-ui-plus';

export default {
    props: ['news', 'title'],
    data() {
        return {
            text: "",
            wordCount: 0, // 用于显示字数的变量
            isReadOnly: true,
            dataURI: null,
            objectURL: null,
            img: null,
            data: null,
        };
    },
    methods: {
        countWords() {
            this.wordCount = this.text.length;
        },
        toggleReadOnly() {
            this.isReadOnly = !this.isReadOnly;
        },
        closeModal() {
            this.$emit('emit-modal');
            if (this.title === '新增消息') {
                this.isReadOnly = false;
            } else {
                this.isReadOnly = true;
            }
        },
        previewObjectURL(e) {
            // let [file] = e.target.files;
            // console.log('previewDataURI', file);
            // this.objectURL = window.URL.createObjectURL(file);
            const file = e.target.files.item(0);
            const reader = new FileReader();
            reader.addEventListener('load', function(e){
                this.news.news_pic = e.target.result;
            });
            reader.readAsDataURL(file);


        },
    },
    watch: {
        title() {
            if (this.title === '新增消息') {
                this.isReadOnly = false;
            } else {
                this.isReadOnly = true;
            }
        }
    },
    computed: {},
    component: {},
    mounted() {
        this.data = this.news;
    },
    components: { Form }
}
</script>
