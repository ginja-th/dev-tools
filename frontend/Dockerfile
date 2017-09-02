# Frontend Docker file

FROM node:6.11-alpine

WORKDIR /usr/src/frontend

RUN npm install -g @angular/cli

# Need to hardcode the public-host here for livereload
CMD ng serve --public-host 'localhost:4200' --host 0.0.0.0 --port 4200