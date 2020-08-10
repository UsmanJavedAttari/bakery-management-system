export class LoaderService {
  private static _Instance: LoaderService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new LoaderService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Linear Loader
  private _LinearLoader = false;
  public LinearLoaderMessage = '';
  get LinearLoader() {
    return this._LinearLoader;
  }
  public showLinearLoader(msg?: string) {
    this.LinearLoaderMessage = msg ?? '';
    this._LinearLoader = true;
  }
  public hideLinearLoader() {
    this._LinearLoader = false;
  }

  // Full Screen Loader
  private FullScreenLoaderCount = 0;
  public FullScreenLoaderMessage = '';
  private _FullScreenLoader = false;
  get FullScreenLoader() {
    return this._FullScreenLoader;
  }
  public showFullScreenLoader(msg?: string, state = true) {
    if (state) {
      this.FullScreenLoaderMessage = msg ?? '';
      this._FullScreenLoader = true;
      this.FullScreenLoaderCount++;
    }
  }
  public hideFullScreenLoader(state = true) {
    if (state) {
      this.FullScreenLoaderCount--;
      if (this.FullScreenLoaderCount === 0) {
        this._FullScreenLoader = false;
      }
    }
  }
}
