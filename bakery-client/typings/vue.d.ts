declare module '*.vue' {
  import Vue from 'vue';
  export default Vue;
}

declare interface AnyObject {
  [key: string]: any;
}

declare interface ApiRes<T = {}> {
  Message: string;
  Status: boolean;
  Data: T;
}
