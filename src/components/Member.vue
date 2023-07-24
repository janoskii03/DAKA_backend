<template>
  <div class="member">
<div class="member_query">

  <ButtonGroup shape="circle" >
    <Button type="black" >新增會員<Icon type="md-add"/></Button>
    
  </ButtonGroup>
  <Select v-model="model" style="width:200px">
    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
  </Select>
  <Input placeholder="Enter text" style="width: auto">
    <template #suffix>
      <Icon type="ios-search" />
    </template>
  </Input>
</div>
    <Table :columns="columns" :data="data" class="member_form"></Table>
    <Page :total="100" class="member_bottom"/>
  </div>
  </template>
<script>
  export default {
      data () {
          return {
              columns: [
                  {
                      title: '姓名',
                      key: 'name'
                  },
                  {
                      title: '會員編號',
                      key: 'number'
                  },
                  {
                      title: '會員等級',
                      key: 'rank'
                  },
                  {
                      title: '手機號碼',
                      key: 'mobile'
                  },
                   {
                      title: '儲值餘額',
                      key: 'remain'
                  },
                   {
                      title: '當年度累積消費金額',
                      key: ''
                  }
              ],
              data: [
                  {
                      name: 'John Brown',
                      age: 18,
                      address: 'New York No. 1 Lake Park',
                      date: '2016-10-03'
                  },
                  {
                      name: 'Jim Green',
                      age: 24,
                      address: 'London No. 1 Lake Park',
                      date: '2016-10-01'
                  },
                  {
                      name: 'Joe Black',
                      age: 30,
                      address: 'Sydney No. 1 Lake Park',
                      date: '2016-10-02'
                  },
                  {
                      name: 'Jon Snow',
                      age: 26,
                      address: 'Ottawa No. 2 Lake Park',
                      date: '2016-10-04'
                  }
              ],
              cityList: [
                    {
                        value: 'New York',
                        label: 'New York'
                    },
                    {
                        value: 'London',
                        label: 'London'
                    },
                    {
                        value: 'Sydney',
                        label: 'Sydney'
                    },
                    {
                        value: 'Ottawa',
                        label: 'Ottawa'
                    },
                    {
                        value: 'Paris',
                        label: 'Paris'
                    },
                    {
                        value: 'Canberra',
                        label: 'Canberra'
                    }
                ],
                model: '',
          }
      }
  }
</script>

<style>

.member{
  max-width: 883px;
  height: 609px;
  margin:0 100px;
  background-color: #fff;
  display: flex;
  flex-direction: column;
}
.member .member_query{
  display: flex;
  justify-content: end;
 align-items: center;
 gap: 10px;
 margin-bottom: 20px;
}
.member_form{
  width: 883px;
  flex-grow: 1;
  background-color: #fff;
 
}
.member_bottom{
  text-align: end;
  margin-top: 18px;
}

</style>