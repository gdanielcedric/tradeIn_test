# Étape 1 : Utiliser une image Node.js officielle
FROM node:18

# Étape 2 : Configurer le répertoire de travail
WORKDIR /app

# Étape 3 : Copier les fichiers du projet
COPY package*.json ./

# Étape 4 : Installer les dépendances
RUN npm install

# Étape 5 : Copier le reste des fichiers
COPY . .

# Étape 6 : Construire l'application pour production
RUN npm run build

# Étape 7 : Utiliser une image Nginx pour servir l'application
FROM nginx:alpine
COPY --from=0 /app/dist /usr/share/nginx/html

# Exposer le port
# EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]