export class SdkConfig {
  private static ApiUrl = 'http://localhost/bakery-api';

  static get ApiPath() {
    return this.ApiUrl;
  }
  static set ApiPath(path: string) {
    this.ApiUrl = path;
  }
}
