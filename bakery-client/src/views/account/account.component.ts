import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import DrawerComponent from '@/components/core/Drawer/drawer.component';
import AppBarComponent from '@/components/core/Appbar/app-bar.component';
import ViewComponent from '@/components/core/View/view.component';

@Component({
  components: {
    DrawerComponent,
    AppBarComponent,
    ViewComponent
  }
})
export default class AccountComponent extends VueWrapper {}
