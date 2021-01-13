FROM co0ontty/maccms_backdoor
RUN touch /error.log && \
    echo "service apache2 start\nservice mysql start\ntail -f /error.log" >> /run.sh 
RUN chmod +x /run.sh
CMD ["sh", "-c", "/run.sh"]