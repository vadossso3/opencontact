create table if not exists currencies
(
    id           int auto_increment,
    name         TINYTEXT null,
    abbreviation tinytext null,
    constraint currencies_pk
    primary key (id)
);

create table exchange_rates
(
    id                 int auto_increment,
    target_currency_id int       not null,
    date               timestamp not null,
    rate               float   not null,
    constraint exchange_rates_pk
        primary key (id),
    constraint exchange_rates_currencies_id_fk
        foreign key (target_currency_id) references currencies (id)
            on update cascade on delete cascade
);
