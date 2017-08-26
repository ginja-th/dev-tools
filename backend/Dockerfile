# Backend Docker file

FROM node:6.11-alpine

ENV NPM_CONFIG_LOGLEVEL error

ADD https://github.com/Yelp/dumb-init/releases/download/v1.2.0/dumb-init_1.2.0_amd64 /usr/local/bin/dumb-init
RUN chmod +x /usr/local/bin/dumb-init

WORKDIR /usr/src/backend

ENV HOST "0.0.0.0"
ENV PORT 3000
EXPOSE 3000

ENTRYPOINT ["dumb-init", "--"]
CMD [ "npm", "run", "dev" ]