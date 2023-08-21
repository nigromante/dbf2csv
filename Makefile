
clean:
	rm -rf ./files/csv/*

start:
	docker-compose up


run: clean start
	 @echo Finaliza 



stop:
	docker-compose down

remove:
	docker rm -f $$(docker ps -aq)  &&  docker rmi -f $$(docker images -aq) 
