let helpers = {
  single: (entity?: any) => {
    return {data: entity}
  },

  missing: (message?: string) => {
    return {code: 404, message: message || 'Resource not found'}
  }
}

export = helpers
