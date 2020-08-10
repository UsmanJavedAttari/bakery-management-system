export class CoreService {
  private static _Instance: CoreService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new CoreService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Linear Loader
  public DrawerMode = true;

  // Alert
  public AlertMode = false;
  public AlertText = '';
  public AlertColor = '';
  public AlertClose = true;
  public static showAlert(
    text: string,
    color?: 'error' | 'success',
    close = true
  ) {
    this.Instance.AlertClose = close;
    this.Instance.AlertMode = true;
    this.Instance.AlertText = text;
    this.Instance.AlertColor = color ?? '';
  }
}
