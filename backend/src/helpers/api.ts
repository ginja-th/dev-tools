interface IValidationErrors {
  [field: string]: string;
};

let helpers = {

  /**
   * 
   */
  single: (entity?: any) => {
    return {data: entity}
  },

  /**
   * 
   */
  missing: (message?: string) => {
    return {code: 404, message: message || 'Resource not found'}
  },

  /**
   * 
   */
  invalid: (errors?: IValidationErrors, message?: string) => {
    return {
      code: 400,
      message: message ? message : 'There was a problem with the request.',
      errors
    };
  },

  /**
   * 
   */
  error: (title?: string, code?: number) => {
    return {
      title: title ? title : 'There was a problem with the request.',
      code: code ? code : 400
    }
  }
}

export = helpers
